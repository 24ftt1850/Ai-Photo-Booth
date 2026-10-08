<?php

use App\Services\GoogleDriveService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/*
 * Google Drive is connected on the RupaVue admin site; the photobooth
 * shares that site's token and Google app credentials.
 */

test('google drive uses the token file shared with the admin site', function () {
    $tokenPath = storage_path('framework/testing/shared-google-token.json');
    @mkdir(dirname($tokenPath), 0755, true);
    @unlink($tokenPath);

    config()->set('services.google_drive.token_path', $tokenPath);

    $googleDrive = new GoogleDriveService;

    expect($googleDrive->isConnected())->toBeFalse();

    file_put_contents($tokenPath, json_encode(['access_token' => 'access', 'refresh_token' => 'refresh']));

    expect($googleDrive->isConnected())->toBeTrue();

    unlink($tokenPath);
});

test('google drive uses the client credentials saved by the admin site', function () {
    $method = new ReflectionMethod(GoogleDriveService::class, 'adminSiteCredentials');

    expect($method->invoke(new GoogleDriveService))->toBeNull();

    Schema::create('google_drive_settings', function (Blueprint $table) {
        $table->id();
        $table->string('client_id')->nullable();
        $table->string('client_secret')->nullable();
    });

    DB::table('google_drive_settings')->insert(['client_id' => 'client-id', 'client_secret' => 'client-secret']);

    expect($method->invoke(new GoogleDriveService))
        ->toBe(['client_id' => 'client-id', 'client_secret' => 'client-secret']);
});

test('admin site credentials are only used with the shared admin token', function () {
    Schema::create('google_drive_settings', function (Blueprint $table) {
        $table->id();
        $table->string('client_id')->nullable();
        $table->string('client_secret')->nullable();
    });

    DB::table('google_drive_settings')->insert(['client_id' => 'admin-client', 'client_secret' => 'admin-secret']);

    $credentialsPath = 'storage/framework/testing/google-credentials.json';
    @mkdir(dirname(base_path($credentialsPath)), 0755, true);
    file_put_contents(base_path($credentialsPath), json_encode([
        'web' => ['client_id' => 'local-client', 'client_secret' => 'local-secret'],
    ]));

    config()->set('services.google_drive.credentials', $credentialsPath);

    $method = new ReflectionMethod(GoogleDriveService::class, 'buildBaseClient');

    config()->set('services.google_drive.token_path', null);
    expect($method->invoke(new GoogleDriveService)->getClientId())->toBe('local-client');

    config()->set('services.google_drive.token_path', storage_path('framework/testing/shared-google-token.json'));
    expect($method->invoke(new GoogleDriveService)->getClientId())->toBe('admin-client');

    unlink(base_path($credentialsPath));
});
