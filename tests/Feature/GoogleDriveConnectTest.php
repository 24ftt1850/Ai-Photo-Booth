<?php

use App\Models\User;
use App\Services\GoogleDriveService;
use Illuminate\Support\Facades\Cache;

/*
 * The photobooth can connect Google Drive itself, using its own
 * credentials.json, when it does not share the admin site's token.
 */

test('the google drive page requires login', function () {
    $this->get(route('google-drive.index'))->assertRedirect(route('login'));
    $this->get(route('google-drive.connect'))->assertRedirect(route('login'));
});

test('the google drive page offers to connect when not connected', function () {
    $this->mock(GoogleDriveService::class, function ($mock) {
        $mock->shouldReceive('isConnected')->andReturnFalse();
        $mock->shouldReceive('usesSharedToken')->andReturnFalse();
        $mock->shouldNotReceive('getFolderInfo');
    });

    $this->actingAs(User::factory()->create())
        ->get(route('google-drive.index'))
        ->assertOk()
        ->assertSee('Not connected')
        ->assertSee('CONNECT GOOGLE DRIVE')
        ->assertSee(route('google-drive.connect'), false);
});

test('the google drive page shows the destination folder when connected', function () {
    $this->mock(GoogleDriveService::class, function ($mock) {
        $mock->shouldReceive('isConnected')->andReturnTrue();
        $mock->shouldReceive('usesSharedToken')->andReturnFalse();
        $mock->shouldReceive('getFolderInfo')->andReturn(['id' => 'folder-id', 'name' => 'RUPAVUE Photos', 'mimeType' => 'application/vnd.google-apps.folder']);
    });

    $this->actingAs(User::factory()->create())
        ->get(route('google-drive.index', ['result' => 'connected']))
        ->assertOk()
        ->assertSee('Connected')
        ->assertSee('RUPAVUE Photos')
        ->assertSee('Generated photos will now be saved to Drive.')
        ->assertSee('RECONNECT GOOGLE DRIVE');
});

test('the google drive page does not connect here while sharing the admin token', function () {
    $this->mock(GoogleDriveService::class, function ($mock) {
        $mock->shouldReceive('isConnected')->andReturnFalse();
        $mock->shouldReceive('usesSharedToken')->andReturnTrue();
        $mock->shouldNotReceive('getAuthUrl');
    });

    $user = User::factory()->create();

    $this->actingAs($user)
        ->get(route('google-drive.index'))
        ->assertOk()
        ->assertSee('GOOGLE_DRIVE_TOKEN_PATH')
        ->assertDontSee(route('google-drive.connect'), false);

    $this->actingAs($user)
        ->get(route('google-drive.connect'))
        ->assertRedirect(route('google-drive.index'));
});

test('connecting redirects to google with a one-time state', function () {
    $state = null;

    $this->mock(GoogleDriveService::class, function ($mock) use (&$state) {
        $mock->shouldReceive('usesSharedToken')->andReturnFalse();
        $mock->shouldReceive('getAuthUrl')->once()->andReturnUsing(function (string $givenState) use (&$state) {
            $state = $givenState;

            return 'https://accounts.google.com/o/oauth2/auth?state='.$givenState;
        });
    });

    $this->actingAs(User::factory()->create())
        ->get(route('google-drive.connect'))
        ->assertRedirect('https://accounts.google.com/o/oauth2/auth?state='.$state);

    expect(Cache::has('google-drive-oauth-state:'.$state))->toBeTrue();
});

test('the callback saves the token and returns to the google drive page', function () {
    config()->set('app.url', 'https://ai-photo-booth-.test');

    Cache::put('google-drive-oauth-state:valid-state', true, now()->addMinutes(15));

    $this->mock(GoogleDriveService::class, function ($mock) {
        $mock->shouldReceive('handleAuthCode')->once()->with('auth-code');
    });

    $this->get(route('google-drive.callback', ['state' => 'valid-state', 'code' => 'auth-code']))
        ->assertRedirect('https://ai-photo-booth-.test/google-drive?result=connected');

    expect(Cache::has('google-drive-oauth-state:valid-state'))->toBeFalse();
});

test('the callback rejects an unknown state', function () {
    config()->set('app.url', 'https://ai-photo-booth-.test');

    $this->mock(GoogleDriveService::class, function ($mock) {
        $mock->shouldNotReceive('handleAuthCode');
    });

    $this->get(route('google-drive.callback', ['state' => 'forged-state', 'code' => 'auth-code']))
        ->assertRedirect('https://ai-photo-booth-.test/google-drive?result=expired');
});

test('the callback reports when google access was denied', function () {
    config()->set('app.url', 'https://ai-photo-booth-.test');

    Cache::put('google-drive-oauth-state:valid-state', true, now()->addMinutes(15));

    $this->get(route('google-drive.callback', ['state' => 'valid-state', 'error' => 'access_denied']))
        ->assertRedirect('https://ai-photo-booth-.test/google-drive?result=denied');
});

test('the callback reports when google rejects the code', function () {
    config()->set('app.url', 'https://ai-photo-booth-.test');

    Cache::put('google-drive-oauth-state:valid-state', true, now()->addMinutes(15));

    $this->mock(GoogleDriveService::class, function ($mock) {
        $mock->shouldReceive('handleAuthCode')->andThrow(new Exception('invalid_grant'));
    });

    $this->get(route('google-drive.callback', ['state' => 'valid-state', 'code' => 'bad-code']))
        ->assertRedirect('https://ai-photo-booth-.test/google-drive?result=failed');
});

test('the auth url uses the photobooth credentials and asks for offline access', function () {
    $credentialsPath = 'storage/framework/testing/google-connect-credentials.json';
    @mkdir(dirname(base_path($credentialsPath)), 0755, true);
    file_put_contents(base_path($credentialsPath), json_encode([
        'web' => ['client_id' => 'booth-client', 'client_secret' => 'booth-secret'],
    ]));

    config()->set('services.google_drive.credentials', $credentialsPath);
    config()->set('services.google_drive.redirect_uri', 'http://127.0.0.1:8000/google-drive/callback');

    $url = (new GoogleDriveService)->getAuthUrl('the-state');

    parse_str((string) parse_url($url, PHP_URL_QUERY), $query);

    expect($query)
        ->client_id->toBe('booth-client')
        ->redirect_uri->toBe('http://127.0.0.1:8000/google-drive/callback')
        ->access_type->toBe('offline')
        ->prompt->toBe('consent')
        ->state->toBe('the-state');

    unlink(base_path($credentialsPath));
});
