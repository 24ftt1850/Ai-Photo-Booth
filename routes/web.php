<?php

use App\Http\Controllers\GeminiController;
use App\Http\Controllers\GoogleDriveController;
use App\Http\Controllers\PhotoboothController;
use App\Http\Controllers\PhotoboothFeedbackController;
use App\Http\Controllers\PhotoboothPrintController;
use App\Http\Controllers\PublicPhotoController;
use App\Models\PhotoFrame;
use App\Models\Theme;
use App\Services\GoogleDriveService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/*
|--------------------------------------------------------------------------
| Public / Guest Photobooth
|--------------------------------------------------------------------------
*/

Route::get('/photobooth', [PhotoboothController::class, 'create'])
    ->name('photobooth.create');

Route::get('/photobooth/scene', [PhotoboothController::class, 'scene'])
    ->name('photobooth.scene');

Route::get('/photobooth/frame', [PhotoboothController::class, 'frame'])
    ->name('photobooth.frame');

Route::get('/photobooth/generate', function () {

    $themeId = request('theme_id');

    $theme = null;

    if ($themeId) {
        $theme = Theme::find($themeId);
    }

    $photoFrames = PhotoFrame::where('is_active', true)->get();

    return view('photobooth.generate', compact('theme', 'photoFrames'));

})->name('photobooth.generate');

Route::get('/photobooth/result', function () {

    $photoFrames = PhotoFrame::where('is_active', true)->get();

    return view('photobooth.result', compact('photoFrames'));

})->name('photobooth.result');

Route::get('/photobooth/feedback', function () {

    $photoFrames = PhotoFrame::where('is_active', true)->get();

    return view('photobooth.feedback', compact('photoFrames'));

})->name('photobooth.feedback');

/*
|--------------------------------------------------------------------------
| Gemini AI Image Generation
|--------------------------------------------------------------------------
*/

Route::post(
    '/gemini-generate',
    [GeminiController::class, 'generateImage']
)->name('gemini.generate');

/*
|--------------------------------------------------------------------------
| Photobooth Feedback
|--------------------------------------------------------------------------
*/

Route::post(
    '/photobooth/feedback',
    [PhotoboothFeedbackController::class, 'store']
)->name('photobooth.feedback.store');

/*
|--------------------------------------------------------------------------
| Photobooth Print (sent to the admin print queue)
|--------------------------------------------------------------------------
*/

Route::post(
    '/photobooth/print',
    [PhotoboothPrintController::class, 'store']
)->name('photobooth.print.store');

/*
|--------------------------------------------------------------------------
| Welcome Page
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    /*
     * Opening the link from outside the booth (a clicked link,
     * bookmark or typed URL) shows the setup page first. Coming
     * back to home from inside the booth goes straight to welcome.
     */
    $refererHost = parse_url((string) request()->headers->get('referer'), PHP_URL_HOST);

    if ($refererHost !== request()->getHost()) {
        return redirect()->route('setup');
    }

    $photoFrames = PhotoFrame::where('is_active', true)->get();

    return view('welcome', compact('photoFrames'));

})->name('home');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
| Where Fortify sends users after logging in. Admin work happens
| on the separate RupaVue admin site, so go back to the booth.
*/

Route::get('/dashboard', function () {

    return redirect()->route('home');

})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Google Drive Connection
|--------------------------------------------------------------------------
| Connect once and generated photos are uploaded to Drive. The
| callback is not behind the login because Google calls back on
| 127.0.0.1; a one-time state proves an admin started it.
*/

Route::middleware('auth')->group(function () {

    Route::get('/google-drive', [GoogleDriveController::class, 'index'])
        ->name('google-drive.index');

    Route::get('/google-drive/connect', [GoogleDriveController::class, 'connect'])
        ->name('google-drive.connect');

});

Route::get('/google-drive/callback', [GoogleDriveController::class, 'callback'])
    ->name('google-drive.callback');


/*
|--------------------------------------------------------------------------
| One-time Setup (IP address + event)
|--------------------------------------------------------------------------
| Loads active occasions from the current database.
| Saves setup selections in the session for now.
| Remote XAMPP connection will be added later.
*/

// Display the setup page.
Route::get('/setup', function (
    Request $request,
    GoogleDriveService $googleDrive
) {
    $occasions = DB::table('occasions')
        ->where('status', 'active')
        ->orderBy('occasion_name')
        ->get(['id', 'occasion_name']);

    return view('photobooth.setup', [
        'occasions' => $occasions,
        'isDriveConnected' => $googleDrive->isConnected(),
        'usesSharedDriveToken' => $googleDrive->usesSharedToken(),
        'driveReconnectDeadline' => $googleDrive->reconnectDeadline(),
        'driveResult' => GoogleDriveController::resultMessage(
            $request->query('result')
        ),
    ]);
})->name('setup');

// Test the remote XAMPP/MySQL connection.
Route::post('/setup/test-remote', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'ip_address' => ['required', 'ip'],
        'remote_port' => ['required', 'integer', 'between:1,65535'],
        'remote_database' => ['required', 'string', 'max:64'],
        'remote_username' => ['required', 'string', 'max:128'],
        'remote_password' => ['present', 'string', 'max:255'],
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $data = $validator->validated();

    try {
        $pdo = new PDO(
            sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
                $data['ip_address'],
                (int) $data['remote_port'],
                $data['remote_database']
            ),
            $data['remote_username'],
            $data['remote_password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 5,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );

        $statement = $pdo->query(
            "SELECT id, occasion_name
             FROM occasions
             WHERE status = 'active'
             ORDER BY occasion_name"
        );

        $occasions = $statement->fetchAll();

        if (count($occasions) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Connected successfully, but no active occasions were found.',
            ], 422);
        }

        // Save the connection settings server-side for this session.
        $request->session()->put('setup.remote', [
            'host' => $data['ip_address'],
            'port' => (int) $data['remote_port'],
            'database' => $data['remote_database'],
            'username' => $data['remote_username'],
            'password' => $data['remote_password'],
        ]);

        $request->session()->put(
            'setup.remote_occasion_ids',
            array_map(
                fn ($occasion) => (int) $occasion['id'],
                $occasions
            )
        );

        return response()->json([
            'success' => true,
            'message' => 'Remote database connection successful.',
            'occasions' => $occasions,
        ]);
    } catch (\Throwable $e) {
        report($e);

        $request->session()->forget([
            'setup.remote',
            'setup.remote_occasion_ids',
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Connection failed. Check the IP, port, database name, credentials, and remote MySQL access.',
        ], 422);
    }
})->name('setup.testRemote');

// Save the selected occasion and connection mode.
Route::post('/setup', function (Request $request) {
    $validated = $request->validate([
        'connection_mode' => ['required', 'in:local,remote'],
        'occasion_id' => ['required', 'integer'],
    ]);

    $occasionId = (int) $validated['occasion_id'];

    if ($validated['connection_mode'] === 'local') {
        $isActive = DB::table('occasions')
            ->where('id', $occasionId)
            ->where('status', 'active')
            ->exists();

        if (! $isActive) {
            return back()->withErrors([
                'occasion_id' => 'Please select an active local occasion.',
            ])->withInput();
        }

        $request->session()->forget([
            'setup.remote',
            'setup.remote_occasion_ids',
        ]);

        $request->session()->put([
            'setup.connection_mode' => 'local',
            'setup.occasion_id' => $occasionId,
            'setup.completed' => true,
        ]);

        return redirect()->route('home');
    }

    $remote = $request->session()->get('setup.remote');
    $allowedIds = $request->session()->get(
        'setup.remote_occasion_ids',
        []
    );

    if (! $remote || ! in_array($occasionId, $allowedIds, true)) {
        return back()->withErrors([
            'occasion_id' => 'Test the remote connection successfully and select one of its active occasions.',
        ])->withInput();
    }

    try {
        // Verify the remote connection again before saving the selection.
        $pdo = new PDO(
            sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
                $remote['host'],
                $remote['port'],
                $remote['database']
            ),
            $remote['username'],
            $remote['password'],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_TIMEOUT => 5,
            ]
        );

        $statement = $pdo->prepare(
            "SELECT id FROM occasions
             WHERE id = ? AND status = 'active'"
        );
        $statement->execute([$occasionId]);

        if (! $statement->fetch()) {
            return back()->withErrors([
                'occasion_id' => 'That remote occasion is no longer active.',
            ])->withInput();
        }
    } catch (\Throwable $e) {
        report($e);

        return back()->withErrors([
            'occasion_id' => 'The remote database is no longer reachable. Test the connection again.',
        ])->withInput();
    }

    $request->session()->put([
        'setup.connection_mode' => 'remote',
        'setup.occasion_id' => $occasionId,
        'setup.completed' => true,
    ]);

    return redirect()->route('home');
})->name('setup.complete');

// Switch back to the existing local .env database.
Route::post('/setup/local', function (Request $request) {
    $request->session()->forget([
        'setup.remote',
        'setup.remote_occasion_ids',
    ]);

    $request->session()->put([
        'setup.connection_mode' => 'local',
        'setup.completed' => true,
    ]);

    return redirect()->route('home');
})->name('setup.local');

Route::get(
    '/photo/{token}',
    [PublicPhotoController::class, 'show']
)->name('public.photo.show');

Route::get(
    '/photo/{token}/download',
    [PublicPhotoController::class, 'download']
)->name('public.photo.download');

Route::get(
    '/photo/{token}/qr',
    [PublicPhotoController::class, 'qrCode']
)->name('public.photo.qr');
