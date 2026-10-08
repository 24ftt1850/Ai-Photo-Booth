<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Google\Service\Drive\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GoogleDriveService
{
    /**
     * Absolute path of the persisted OAuth token.
     *
     * Kept on disk instead of the PHP session so that any
     * request (including unattended kiosk requests that never
     * touch the OAuth flow themselves) can upload to Drive once
     * an admin has connected the account a single time.
     *
     * GOOGLE_DRIVE_TOKEN_PATH points this at the RupaVue admin
     * site's token, so connecting Google there also connects
     * the photobooth.
     */
    private function tokenPath(): string
    {
        return config('services.google_drive.token_path')
            ?: storage_path('app/private/google/token.json');
    }

    /**
     * Build a fresh, unauthenticated Google client.
     *
     * A token must be refreshed with the Google app that issued
     * it, so the RupaVue admin site's client id/secret are only
     * used with its shared token (GOOGLE_DRIVE_TOKEN_PATH); the
     * local token uses this app's own credentials.json.
     */
    private function buildBaseClient(): Client
    {
        $client = new Client;

        $adminCredentials = config('services.google_drive.token_path')
            ? $this->adminSiteCredentials()
            : null;

        if ($adminCredentials) {
            $client->setClientId($adminCredentials['client_id']);
            $client->setClientSecret($adminCredentials['client_secret']);
        } else {
            $client->setAuthConfig(base_path(
                config('services.google_drive.credentials')
            ));
        }

        $client->addScope(Drive::DRIVE);

        return $client;
    }

    /**
     * Whether we currently hold a usable (refreshable) token.
     */
    public function isConnected(): bool
    {
        $token = $this->loadToken();

        return $token !== null
            && ! empty($token['refresh_token']);
    }

    /**
     * Client id/secret the RupaVue admin site keeps in the shared
     * google_drive_settings table, so the photobooth refreshes the
     * shared token with the same Google app as the admin site.
     *
     * @return array{client_id: string, client_secret: string}|null
     */
    private function adminSiteCredentials(): ?array
    {
        try {
            $settings = DB::table('google_drive_settings')->first(['client_id', 'client_secret']);
        } catch (\Throwable) {
            return null;
        }

        if (! $settings || blank($settings->client_id) || blank($settings->client_secret)) {
            return null;
        }

        return [
            'client_id' => $settings->client_id,
            'client_secret' => $settings->client_secret,
        ];
    }

    private function loadToken(): ?array
    {
        if (! File::exists($this->tokenPath())) {
            return null;
        }

        $token = json_decode(
            File::get($this->tokenPath()),
            true
        );

        return is_array($token) ? $token : null;
    }

    private function saveToken(array $token): void
    {
        /*
        |--------------------------------------------------------------------------
        | Google only sends refresh_token on the FIRST consent.
        | Preserve the existing one if a refresh response omits it.
        |--------------------------------------------------------------------------
        */

        if (empty($token['refresh_token'])) {

            $existing = $this->loadToken();

            if ($existing && ! empty($existing['refresh_token'])) {
                $token['refresh_token'] = $existing['refresh_token'];
            }
        }

        File::ensureDirectoryExists(dirname($this->tokenPath()));

        File::put(
            $this->tokenPath(),
            json_encode($token, JSON_PRETTY_PRINT)
        );
    }

    private function forgetToken(): void
    {
        File::delete($this->tokenPath());
    }

    /**
     * Build an authenticated client, refreshing the access token
     * from the stored refresh token whenever it has expired.
     */
    private function getClient(): Client
    {
        $token = $this->loadToken();

        if (! $token) {
            throw new \Exception(
                'Google Drive is not connected. Please connect it from the RupaVue admin site first.'
            );
        }

        $client = $this->buildBaseClient();

        $client->setAccessToken($token);

        if ($client->isAccessTokenExpired()) {

            $refreshToken = $token['refresh_token']
                ?? $client->getRefreshToken();

            if (! $refreshToken) {
                throw new \Exception(
                    'Google Drive access has expired and there is no refresh token. Please reconnect Google Drive.'
                );
            }

            $refreshed = $client->fetchAccessTokenWithRefreshToken(
                $refreshToken
            );

            if (isset($refreshed['error'])) {

                /*
                 * A revoked or expired refresh token can never work
                 * again, so forget it and let the RupaVue admin site
                 * show that Google must be reconnected.
                 */
                if ($refreshed['error'] === 'invalid_grant') {
                    $this->forgetToken();
                }

                throw new \Exception(
                    'Failed to refresh Google Drive access: '.
                    ($refreshed['error_description'] ?? $refreshed['error'])
                );
            }

            $this->saveToken($refreshed);

            $client->setAccessToken($refreshed);
        }

        return $client;
    }

    /**
     * Fetch metadata for the configured destination folder, used
     * to confirm the connection is working.
     */
    public function getFolderInfo(): array
    {
        $client = $this->getClient();

        $drive = new Drive($client);

        $folderId = config('services.google_drive.generated_folder_id');

        if (! $folderId) {
            throw new \Exception(
                'GOOGLE_DRIVE_GENERATED_FOLDER_ID is not configured.'
            );
        }

        $folder = $drive->files->get(
            $folderId,
            ['fields' => 'id,name,mimeType']
        );

        return [
            'id' => $folder->getId(),
            'name' => $folder->getName(),
            'mimeType' => $folder->getMimeType(),
        ];
    }

    /**
     * Upload an image to the RUPAVUE Google Drive folder.
     */
    public function uploadImage(
        string $localFilePath,
        string $fileName
    ): array {

        if (! file_exists($localFilePath)) {
            throw new \Exception(
                'Image file does not exist: '.$localFilePath
            );
        }

        $client = $this->getClient();

        $drive = new Drive($client);

        $folderId = config('services.google_drive.generated_folder_id');

        if (! $folderId) {
            throw new \Exception(
                'GOOGLE_DRIVE_GENERATED_FOLDER_ID is not configured.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Google Drive file metadata
        |--------------------------------------------------------------------------
        */

        $fileMetadata = new DriveFile([
            'name' => $fileName,

            'parents' => [
                $folderId,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Read image
        |--------------------------------------------------------------------------
        */

        $content = file_get_contents(
            $localFilePath
        );

        if ($content === false) {
            throw new \Exception(
                'Unable to read image file.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Determine MIME type
        |--------------------------------------------------------------------------
        */

        $mimeType = mime_content_type(
            $localFilePath
        );

        if (! $mimeType) {
            $mimeType = 'image/png';
        }

        /*
        |--------------------------------------------------------------------------
        | Upload
        |--------------------------------------------------------------------------
        */

        $file = $drive->files->create(
            $fileMetadata,
            [
                'data' => $content,

                'mimeType' => $mimeType,

                'uploadType' => 'multipart',

                'fields' => 'id,name,mimeType,webViewLink',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Return Google Drive information
        |--------------------------------------------------------------------------
        */

        return [
            'id' => $file->getId(),

            'name' => $file->getName(),

            'mimeType' => $file->getMimeType(),

            'url' => $file->getWebViewLink(),
        ];
    }

    public function makeFilePublic(string $fileId): void
    {
        if (empty($fileId)) {
            throw new \Exception('Google Drive file ID is empty.');
        }

        $client = $this->getClient();
        $drive = new Drive($client);

        $permission = new Permission([
            'type' => 'anyone',
            'role' => 'reader',
        ]);

        $drive->permissions->create(
            $fileId,
            $permission
        );
    }

    /**
     * Download a file from Google Drive.
     *
     * The file is downloaded using its Google Drive file ID
     * and saved to a local temporary path.
     */
    public function downloadFile(
        string $fileId,
        string $localFilePath
    ): string {

        if (empty($fileId)) {
            throw new \Exception(
                'Google Drive file ID is empty.'
            );
        }

        $client = $this->getClient();

        $drive = new Drive($client);

        /*
        |--------------------------------------------------------------------------
        | Download file from Google Drive
        |--------------------------------------------------------------------------
        */

        $response = $drive->files->get(
            $fileId,
            [
                'alt' => 'media',
            ]
        );

        $content = $response->getBody()->getContents();

        if ($content === false || $content === '') {
            throw new \Exception(
                'Unable to download the file from Google Drive.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Make sure destination directory exists
        |--------------------------------------------------------------------------
        */

        $directory = dirname($localFilePath);

        if (! is_dir($directory)) {
            mkdir(
                $directory,
                0755,
                true
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Save downloaded file
        |--------------------------------------------------------------------------
        */

        $written = file_put_contents(
            $localFilePath,
            $content
        );

        if ($written === false) {
            throw new \Exception(
                'Unable to save the downloaded Google Drive file.'
            );
        }

        return $localFilePath;
    }
}
