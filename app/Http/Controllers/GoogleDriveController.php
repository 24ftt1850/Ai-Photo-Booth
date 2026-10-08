<?php

namespace App\Http\Controllers;

use App\Services\GoogleDriveService;
use Google\Service\Drive\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class GoogleDriveController extends Controller
{
    private const STATE_CACHE_PREFIX = 'google-drive-oauth-state:';

    /**
     * Redirect the admin to Google's authorization page.
     * This only needs to be done once - the token is then
     * persisted to disk and auto-refreshed afterwards.
     */
    public function connect(GoogleDriveService $googleDrive)
    {
        /*
         * One-time state, kept in the cache rather than the session:
         * Google calls back on 127.0.0.1, which does not share the
         * admin's session with the Herd site.
         */
        $state = Str::random(40);

        Cache::put(self::STATE_CACHE_PREFIX.$state, true, now()->addMinutes(15));

        return redirect()->away(
            $googleDrive->getAuthUrl($state)
        );
    }

    /**
     * Receive Google's OAuth callback and persist the token.
     *
     * Not behind the admin login (see connect()); the one-time
     * state proves an admin started this connection.
     */
    public function callback(
        Request $request,
        GoogleDriveService $googleDrive
    ): RedirectResponse {
        $state = (string) $request->query('state');

        if ($state === '' || ! Cache::pull(self::STATE_CACHE_PREFIX.$state)) {
            return $this->redirectToAdmin('error', 'This Google connection link has expired. Please click Connect Google again.');
        }

        if (! $request->has('code')) {
            return $this->redirectToAdmin('error', $request->query('error') === 'access_denied'
                ? 'Google access was not granted.'
                : 'Google authorization code was not provided.');
        }

        try {
            $googleDrive->handleAuthCode(
                $request->query('code')
            );

        } catch (\Throwable $e) {

            return $this->redirectToAdmin('error', 'Unable to connect Google Drive: '.$e->getMessage());
        }

        return $this->redirectToAdmin('status', 'Google Drive connected. Generated photos will now be saved to Drive.');
    }

    /**
     * Back to the admin Google Drive page: on this host when the
     * admin is logged in here, otherwise on the main site (APP_URL).
     */
    private function redirectToAdmin(string $flashKey, string $message): RedirectResponse
    {
        if (auth()->check()) {
            return redirect()->route('admin.google-drive.index')->with($flashKey, $message);
        }

        return redirect()->away(
            rtrim(config('app.url'), '/').route('admin.google-drive.index', absolute: false)
        );
    }

    /**
     * Test the persisted Google Drive connection.
     */
    public function test(GoogleDriveService $googleDrive)
    {
        if (! $googleDrive->isConnected()) {
            return redirect()->route('google-drive.connect');
        }

        try {

            $folder = $googleDrive->getFolderInfo();

            return response()->json([
                'success' => true,
                'message' => 'Google Drive connected successfully.',
                'folder' => $folder,
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
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
     * Test uploading a file to Google Drive.
     */
    public function uploadTest(GoogleDriveService $googleDrive)
    {
        if (! $googleDrive->isConnected()) {
            return redirect()->route('google-drive.connect');
        }

        try {

            /*
            |--------------------------------------------------------------------------
            | Create temporary test file
            |--------------------------------------------------------------------------
            */

            $googleFolder = storage_path('app/google');

            if (! is_dir($googleFolder)) {
                mkdir($googleFolder, 0755, true);
            }

            $testFilePath = $googleFolder.'/rupavue-test.txt';

            file_put_contents(
                $testFilePath,
                'RUPAVUE Google Drive upload test - '.now()
            );

            /*
            |--------------------------------------------------------------------------
            | Upload to Google Drive
            |--------------------------------------------------------------------------
            */

            $file = $googleDrive->uploadImage(
                $testFilePath,
                'RUPAVUE-Test-'.
                    now()->format('Ymd-His').
                    '.txt'
            );

            return response()->json([
                'success' => true,

                'message' => 'Test file uploaded successfully.',

                'file' => $file,
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,

                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
