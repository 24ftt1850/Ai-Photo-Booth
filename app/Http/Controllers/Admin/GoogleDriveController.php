<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhotoFrame;
use App\Services\GoogleDriveService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GoogleDriveController extends Controller
{
    /**
     * Connection status plus the photo frames read from Google Drive.
     */
    public function index(GoogleDriveService $googleDrive): View
    {
        $isConnected = $googleDrive->isConnected();
        $connectedEmail = null;
        $connectionError = null;

        if ($isConnected) {
            try {
                $connectedEmail = $googleDrive->connectedAccountEmail();
            } catch (\Throwable $e) {
                $connectionError = $e->getMessage();
                $isConnected = $googleDrive->isConnected();
            }
        }

        $frames = PhotoFrame::whereNotNull('google_drive_file_id')->latest('id')->get();

        return view('admin.google-drive.index', [
            'isConnected' => $isConnected,
            'connectedEmail' => $connectedEmail,
            'connectionError' => $connectionError,
            'hasGeneratedFolder' => filled(config('services.google_drive.generated_folder_id')),
            'hasFramesFolder' => filled(config('services.google_drive.frames_folder_id')),
            'frames' => $frames,
        ]);
    }

    public function disconnect(GoogleDriveService $googleDrive): RedirectResponse
    {
        $googleDrive->disconnect();

        return redirect()->route('admin.google-drive.index')->with('status', 'Google Drive disconnected.');
    }

    /**
     * Read every image in the Drive frames folder into photo_frames,
     * keeping a local copy of each frame for previews.
     */
    public function syncFrames(GoogleDriveService $googleDrive): RedirectResponse
    {
        try {
            $driveFrames = $googleDrive->listFrameFiles();
        } catch (\Throwable $e) {
            return redirect()->route('admin.google-drive.index')->with('error', $e->getMessage());
        }

        $synced = 0;
        $failed = 0;

        foreach ($driveFrames as $driveFrame) {
            $framePath = 'frames/drive_'.preg_replace('/[^A-Za-z0-9_-]/', '', $driveFrame['id']).'.png';

            try {
                $googleDrive->downloadFile($driveFrame['id'], Storage::disk('public')->path($framePath));
            } catch (\Throwable $e) {
                $failed++;

                Log::error('RUPAVUE Google Drive frame sync failed.', [
                    'google_drive_file_id' => $driveFrame['id'],
                    'error' => $e->getMessage(),
                ]);

                continue;
            }

            $frame = PhotoFrame::firstOrNew(['google_drive_file_id' => $driveFrame['id']]);

            if (! $frame->exists) {
                $frame->is_active = true;
            }

            $frame->fill([
                'frame_name' => Str::limit(pathinfo($driveFrame['name'], PATHINFO_FILENAME), 100, ''),
                'frame_path' => $framePath,
                'google_drive_url' => $driveFrame['url'],
                'google_drive_status' => 'synced',
            ])->save();

            $synced++;
        }

        $message = "{$synced} frame(s) read from Google Drive.";

        if ($failed > 0) {
            $message .= " {$failed} could not be downloaded.";
        }

        return redirect()->route('admin.google-drive.index')->with('status', $message);
    }

    public function toggleFrame(PhotoFrame $photoFrame): RedirectResponse
    {
        $photoFrame->update(['is_active' => ! $photoFrame->is_active]);

        return redirect()->route('admin.google-drive.index')->with('status', 'Frame updated.');
    }
}
