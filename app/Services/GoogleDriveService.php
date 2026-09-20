<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;
use Illuminate\Support\Facades\Storage;

class GoogleDriveService
{
    /**
     * Where the OAuth token is persisted, relative to the
     * "local" storage disk (storage/app/...).
     *
     * Kept on disk instead of the PHP session so that any
     * request (including unattended kiosk requests that never
     * touch the OAuth flow themselves) can upload to Drive once
     * an admin has connected the account a single time.
     */
    private const TOKEN_PATH = 'google/token.json';

    /**
     * Build a fresh, unauthenticated Google client using the
     * credentials provided by the admin (client id/secret).
     */
    private function buildBaseClient(): Client
    {
        $client = new Client();

        $credentialsPath = base_path(
            env(
                'GOOGLE_DRIVE_CREDENTIALS',
                'storage/app/google/credentials.json'
            )
        );

        $client->setAuthConfig($credentialsPath);

        $client->setRedirectUri(
            env(
                'GOOGLE_DRIVE_REDIRECT_URI',
                'http://127.0.0.1:8000/google-drive/callback'
            )
        );

        $client->setAccessType('offline');
        $client->setPrompt('consent');

        $client->addScope(Drive::DRIVE);

        return $client;
    }


    /**
     * URL the admin visits once to grant Drive access.
     */
    public function getAuthUrl(): string
    {
        return $this->buildBaseClient()->createAuthUrl();
    }


    /**
     * Exchange the OAuth code for a token and persist it to disk.
     */
    public function handleAuthCode(string $code): array
    {
        $client = $this->buildBaseClient();

        $token = $client->fetchAccessTokenWithAuthCode($code);

        if (isset($token['error'])) {
            throw new \Exception(
                $token['error_description'] ?? $token['error']
            );
        }

        $this->saveToken($token);

        return $token;
    }


    /**
     * Whether we currently hold a usable (refreshable) token.
     */
    public function isConnected(): bool
    {
        $token = $this->loadToken();

        return $token !== null
            && !empty($token['refresh_token']);
    }


    private function loadToken(): ?array
    {
        if (!Storage::disk('local')->exists(self::TOKEN_PATH)) {
            return null;
        }

        $token = json_decode(
            Storage::disk('local')->get(self::TOKEN_PATH),
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

            if ($existing && !empty($existing['refresh_token'])) {
                $token['refresh_token'] = $existing['refresh_token'];
            }
        }

        Storage::disk('local')->put(
            self::TOKEN_PATH,
            json_encode($token)
        );
    }


    /**
     * Build an authenticated client, refreshing the access token
     * from the stored refresh token whenever it has expired.
     */
    private function getClient(): Client
    {
        $token = $this->loadToken();

        if (!$token) {
            throw new \Exception(
                'Google Drive is not connected. Please connect it from the admin panel first.'
            );
        }

        $client = $this->buildBaseClient();

        $client->setAccessToken($token);

        if ($client->isAccessTokenExpired()) {

            $refreshToken = $token['refresh_token']
                ?? $client->getRefreshToken();

            if (!$refreshToken) {
                throw new \Exception(
                    'Google Drive access has expired and there is no refresh token. Please reconnect Google Drive.'
                );
            }

            $refreshed = $client->fetchAccessTokenWithRefreshToken(
                $refreshToken
            );

            if (isset($refreshed['error'])) {
                throw new \Exception(
                    'Failed to refresh Google Drive access: ' .
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

        $folderId = env('GOOGLE_DRIVE_GENERATED_FOLDER_ID');

        if (!$folderId) {
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
     *
     * @param string $localFilePath
     * @param string $fileName
     * @return array
     */
    public function uploadImage(
        string $localFilePath,
        string $fileName
    ): array {

        if (!file_exists($localFilePath)) {
            throw new \Exception(
                'Image file does not exist: ' . $localFilePath
            );
        }

        $client = $this->getClient();

        $drive = new Drive($client);

        $folderId = env(
            'GOOGLE_DRIVE_GENERATED_FOLDER_ID'
        );

        if (!$folderId) {
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
                $folderId
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

        if (!$mimeType) {
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

                'fields' =>
                    'id,name,mimeType,webViewLink',
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

    $permission = new \Google\Service\Drive\Permission([
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

    if (!is_dir($directory)) {
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
