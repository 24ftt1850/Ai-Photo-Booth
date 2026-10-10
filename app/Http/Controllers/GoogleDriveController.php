<?php

namespace App\Http\Controllers;

use App\Services\GoogleDriveService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\View\View;

class GoogleDriveController extends Controller
{
    private const STATE_CACHE_PREFIX = 'google-drive-oauth-state:';

    /**
     * Messages the callback may show, keyed by the code it passes
     * back in the query string (never free text from the URL).
     *
     * @var array<string, array{type: string, message: string}>
     */
    private const RESULTS = [
        'connected' => ['type' => 'success', 'message' => 'Google Drive connected. Generated photos will now be saved to Drive.'],
        'expired' => ['type' => 'error', 'message' => 'This Google connection link has expired. Please click Connect Google Drive again.'],
        'denied' => ['type' => 'error', 'message' => 'Google access was not granted.'],
        'failed' => ['type' => 'error', 'message' => 'Unable to connect Google Drive. Check the log for details.'],
    ];

    /**
     * Show whether the photobooth is connected to Google Drive.
     */
    public function index(Request $request, GoogleDriveService $googleDrive): View
    {
        $isConnected = $googleDrive->isConnected();
        $folder = null;
        $folderError = null;

        if ($isConnected) {
            try {
                $folder = $googleDrive->getFolderInfo();
            } catch (\Throwable $e) {
                $folderError = $e->getMessage();
            }
        }

        return view('google-drive.index', [
            'isConnected' => $isConnected,
            'usesSharedToken' => $googleDrive->usesSharedToken(),
            'folder' => $folder,
            'folderError' => $folderError,
            'result' => self::RESULTS[(string) $request->query('result')] ?? null,
        ]);
    }

    /**
     * Send the admin to Google's authorization page.
     *
     * The one-time state is kept in the cache rather than the
     * session: Google calls back on 127.0.0.1, which does not
     * share the session with the Herd site.
     */
    public function connect(GoogleDriveService $googleDrive): RedirectResponse
    {
        if ($googleDrive->usesSharedToken()) {
            return redirect()->route('google-drive.index');
        }

        $state = Str::random(40);

        Cache::put(self::STATE_CACHE_PREFIX.$state, true, now()->addMinutes(15));

        return redirect()->away($googleDrive->getAuthUrl($state));
    }

    /**
     * Receive Google's OAuth callback and persist the token.
     *
     * Not behind the login (see connect()); the one-time state
     * proves a logged-in admin started this connection.
     */
    public function callback(Request $request, GoogleDriveService $googleDrive): RedirectResponse
    {
        $state = (string) $request->query('state');

        if ($state === '' || ! Cache::pull(self::STATE_CACHE_PREFIX.$state)) {
            return $this->redirectToIndex('expired');
        }

        if (! $request->filled('code')) {
            return $this->redirectToIndex($request->query('error') === 'access_denied' ? 'denied' : 'failed');
        }

        try {
            $googleDrive->handleAuthCode((string) $request->query('code'));
        } catch (\Throwable $e) {
            Log::error('RUPAVUE Google Drive connection failed.', ['error' => $e->getMessage()]);

            return $this->redirectToIndex('failed');
        }

        return $this->redirectToIndex('connected');
    }

    /**
     * Back to the Google Drive page on the main site (APP_URL),
     * since the callback arrives on 127.0.0.1.
     */
    private function redirectToIndex(string $result): RedirectResponse
    {
        return redirect()->away(
            rtrim((string) config('app.url'), '/').route('google-drive.index', ['result' => $result], absolute: false)
        );
    }
}
