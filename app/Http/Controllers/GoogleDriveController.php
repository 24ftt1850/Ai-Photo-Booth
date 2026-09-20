<?php

namespace App\Http\Controllers;

use App\Services\GoogleDriveService;
use Illuminate\Http\Request;

class GoogleDriveController extends Controller
{
    /**
     * Redirect the admin to Google's authorization page.
     * This only needs to be done once - the token is then
     * persisted to disk and auto-refreshed afterwards.
     */
    public function connect(GoogleDriveService $googleDrive)
    {
        return redirect()->away(
            $googleDrive->getAuthUrl()
        );
    }


    /**
     * Receive Google's OAuth callback and persist the token.
     */
    public function callback(
        Request $request,
        GoogleDriveService $googleDrive
    ) {
        if (!$request->has('code')) {
            return response()->json([
                'success' => false,
                'message' => 'Google authorization code was not provided.',
            ], 400);
        }

        try {
            $googleDrive->handleAuthCode(
                $request->get('code')
            );

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }

        return redirect()->route('google-drive.test');
    }


    /**
     * Test the persisted Google Drive connection.
     */
    public function test(GoogleDriveService $googleDrive)
    {
        if (!$googleDrive->isConnected()) {
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
     * Test uploading a file to Google Drive.
     */
    public function uploadTest(GoogleDriveService $googleDrive)
    {
        if (!$googleDrive->isConnected()) {
            return redirect()->route('google-drive.connect');
        }

        try {

            /*
            |--------------------------------------------------------------------------
            | Create temporary test file
            |--------------------------------------------------------------------------
            */

            $googleFolder = storage_path('app/google');

            if (!is_dir($googleFolder)) {
                mkdir($googleFolder, 0755, true);
            }

            $testFilePath = $googleFolder . '/rupavue-test.txt';

            file_put_contents(
                $testFilePath,
                'RUPAVUE Google Drive upload test - ' . now()
            );


            /*
            |--------------------------------------------------------------------------
            | Upload to Google Drive
            |--------------------------------------------------------------------------
            */

            $file = $googleDrive->uploadImage(
                $testFilePath,
                'RUPAVUE-Test-' .
                    now()->format('Ymd-His') .
                    '.txt'
            );


            return response()->json([
                'success' => true,

                'message' =>
                    'Test file uploaded successfully.',

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
