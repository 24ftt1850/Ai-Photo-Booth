<?php

use App\Http\Controllers\GeminiController;
use App\Models\GeneratedImage;
use App\Models\PhotoFrame;
use App\Services\GoogleDriveService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/*
 * The live generated_images table has columns the migrations lack.
 */
beforeEach(function () {
    Schema::table('generated_images', function (Blueprint $table) {
        $table->string('generated_photo_path')->nullable();
        $table->string('generation_status')->nullable();
    });
});

function makePublicPhoto(array $attributes = []): GeneratedImage
{
    return GeneratedImage::factory()->create(array_merge([
        'theme_id' => null,
        'public_token' => 'token-123',
        'image_uid' => 'RV-20260930-ABC123',
        'generated_photo_path' => 'photobooth/final.png',
        'generation_status' => 'success',
    ], $attributes));
}

test('generator applies the frame the guest picked', function () {
    $source = file_get_contents(app_path('Http/Controllers/GeminiController.php'));

    expect($source)
        ->toContain('$this->localFramePath($activeFrame, $googleDrive)')
        ->toContain("PhotoFrame::selectable()->find(\$request->integer('frame_id'))")
        ->toContain("?? PhotoFrame::selectable()->latest('id')->first()")
        ->toContain("'frame_applied' => \$appliedFramePath !== null");

    $html = (string) $this->view('photobooth.generate', ['theme' => null, 'photoFrames' => collect()]);

    expect($html)->toMatch("/frame_id:\s*sessionStorage\.getItem\('rupavueFrameId'\)/");
});

test('generator always returns a photo link and a qr code url', function () {
    $source = file_get_contents(app_path('Http/Controllers/GeminiController.php'));

    expect($source)
        ->toContain("'public_photo_url' => \$generatedRecord->publicPhotoUrl()")
        ->toContain("'qr_code_url' => route('public.photo.qr', \$generatedRecord->public_token)");
});

test('photo link is the public google drive file when shared, otherwise the photo page', function () {
    $shared = new GeneratedImage([
        'public_token' => 'token-123',
        'google_drive_status' => 'public',
        'google_drive_url' => 'https://drive.google.com/file/d/abc/view',
    ]);

    expect($shared->publicPhotoUrl())->toBe('https://drive.google.com/file/d/abc/view');

    $notShared = new GeneratedImage([
        'public_token' => 'token-123',
        'google_drive_status' => 'uploaded',
        'google_drive_url' => 'https://drive.google.com/file/d/abc/view',
    ]);

    expect($notShared->publicPhotoUrl())->toBe(route('public.photo.show', 'token-123'));
});

test('each generated image has its own qr code png', function () {
    makePublicPhoto();

    $response = $this->get(route('public.photo.qr', 'token-123'))
        ->assertOk()
        ->assertHeader('Content-Type', 'image/png');

    expect($response->getContent())->toStartWith("\x89PNG");
});

test('qr code is not found for an unknown or failed photo', function () {
    makePublicPhoto(['public_token' => 'failed-token', 'generation_status' => 'failed_other']);

    $this->get(route('public.photo.qr', 'missing-token'))->assertNotFound();
    $this->get(route('public.photo.qr', 'failed-token'))->assertNotFound();
});

test('result page shows the qr code image for the generated photo', function () {
    $generateHtml = (string) $this->view('photobooth.generate', ['theme' => null, 'photoFrames' => collect()]);

    expect($generateHtml)->toMatch("/sessionStorage\.setItem\(\s*'rupavueQrCodeUrl',\s*data\.qr_code_url \|\| ''\s*\)/");

    $resultHtml = (string) $this->view('photobooth.result', ['photoFrames' => collect()]);

    expect($resultHtml)->toContain("'rupavueQrCodeUrl'")
        ->toMatch('/if \(qrCodeUrl\) \{.*?qrImage\.src = qrCodeUrl;/s')
        ->toMatch('/qrImage\.onerror = \(\) => \{.*?drawQRCodeInBrowser\(\);/s');
});

test('public photo download serves the local copy when the photo is not on google drive', function () {
    Storage::fake('public');
    Storage::disk('public')->put('photobooth/final.png', 'png-bytes');

    makePublicPhoto();

    $this->get(route('public.photo.download', 'token-123'))
        ->assertOk()
        ->assertDownload('RUPAVUE-RV-20260930-ABC123.png');
});

test('public photo download falls back to the local copy when google drive fails', function () {
    Storage::fake('public');
    Storage::disk('public')->put('photobooth/final.png', 'png-bytes');

    makePublicPhoto(['google_drive_file_id' => 'drive-file']);

    $this->mock(GoogleDriveService::class, function ($mock) {
        $mock->shouldReceive('downloadFile')->andThrow(new Exception('Token has been expired or revoked.'));
    });

    $this->get(route('public.photo.download', 'token-123'))
        ->assertOk()
        ->assertDownload('RUPAVUE-RV-20260930-ABC123.png');
});

test('public photo download is not found when no copy exists', function () {
    Storage::fake('public');

    makePublicPhoto();

    $this->get(route('public.photo.download', 'token-123'))->assertNotFound();
});

test('frame is fetched from its public google drive link and kept locally when drive is disconnected', function () {
    Storage::fake('public');

    Schema::create('photo_frames', function (Blueprint $table) {
        $table->id();
        $table->string('frame_name', 100);
        $table->string('frame_path');
        $table->string('google_drive_file_id')->nullable();
        $table->text('google_drive_url')->nullable();
        $table->string('google_drive_status', 30)->nullable();
        $table->text('description')->nullable();
        $table->boolean('is_active')->nullable()->default(true);
        $table->timestamps();
    });

    $frame = PhotoFrame::create([
        'frame_name' => 'Rupa Frame',
        'frame_path' => 'frames/rupa.png',
        'google_drive_file_id' => 'drive-rupa',
        'is_active' => true,
    ]);

    $googleDrive = Mockery::mock(GoogleDriveService::class);
    $googleDrive->shouldReceive('downloadFile')->once()->andThrow(new Exception('Google Drive is not connected.'));

    Http::fake([
        'drive.google.com/*' => Http::response('frame-png', 200, ['Content-Type' => 'image/png']),
    ]);

    $method = new ReflectionMethod(GeminiController::class, 'localFramePath');

    expect($method->invoke(app(GeminiController::class), $frame, $googleDrive))->toBe('frames/rupa.png');
    Storage::disk('public')->assertExists('frames/rupa.png');

    // The local copy is reused without touching Google Drive again.
    expect($method->invoke(app(GeminiController::class), $frame, $googleDrive))->toBe('frames/rupa.png');
    Http::assertSentCount(1);
});

test('frame download fails when the public link does not return an image', function () {
    Storage::fake('public');

    $frame = new PhotoFrame(['frame_name' => 'Private', 'frame_path' => 'frames/private.png', 'google_drive_file_id' => 'drive-private']);

    $googleDrive = Mockery::mock(GoogleDriveService::class);
    $googleDrive->shouldReceive('downloadFile')->andThrow(new Exception('Google Drive is not connected.'));

    Http::fake(['drive.google.com/*' => Http::response('<html>Sign in</html>', 200, ['Content-Type' => 'text/html'])]);

    $method = new ReflectionMethod(GeminiController::class, 'localFramePath');

    expect(fn () => $method->invoke(app(GeminiController::class), $frame, $googleDrive))
        ->toThrow(Exception::class, 'Unable to download the photo frame');
});
