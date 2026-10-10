<?php

use App\Http\Controllers\GeminiController;
use App\Models\GeneratedImage;
use App\Services\GoogleDriveService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/*
 * The booth writes to tables owned by the RupaVue admin site; shape the
 * test database like the live one for the columns the generator uses.
 */
beforeEach(function () {
    Storage::fake('public');
    config()->set('services.gemini.model', 'test-model');
    config()->set('services.gemini.api_key', 'test-key');

    Schema::create('photoshoot_themes', function (Blueprint $table) {
        $table->id();
        $table->string('theme_name');
        $table->text('prompt_prefix')->nullable();
        $table->text('prompt_suffix')->nullable();
        $table->unsignedBigInteger('photo_frame_id')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });

    Schema::create('occasions', function (Blueprint $table) {
        $table->id();
        $table->string('status');
    });

    Schema::create('photo_frames', function (Blueprint $table) {
        $table->id();
        $table->string('frame_name');
        $table->string('frame_path');
        $table->string('google_drive_file_id')->nullable();
        $table->text('description')->nullable();
        $table->boolean('is_active')->default(true);
        $table->boolean('is_default')->default(false);
        $table->timestamps();
    });

    Schema::create('booth_settings', function (Blueprint $table) {
        $table->id();
        $table->boolean('guests_can_pick_frame')->default(false);
        $table->timestamps();
    });

    Schema::table('photo_sessions', function (Blueprint $table) {
        $table->foreignId('event_id')->nullable()->change();
        $table->string('session_code')->nullable();
        $table->string('raw_photo_path')->nullable();
        $table->boolean('consent_given')->default(true);
        $table->unsignedBigInteger('occasion_id')->nullable();
    });

    Schema::table('generated_images', function (Blueprint $table) {
        $table->foreignId('event_id')->nullable()->change();
        $table->unsignedBigInteger('model_id')->nullable();
        $table->unsignedBigInteger('chosen_frame_id')->nullable();
        $table->text('final_prompt_used')->nullable();
        $table->string('generation_status')->nullable();
        $table->string('generated_photo_path')->nullable();
        $table->string('applied_frame_path')->nullable();
    });

    DB::table('photoshoot_themes')->insert(['id' => 5, 'theme_name' => 'Galaxy', 'prompt_prefix' => 'A galaxy portrait', 'photo_frame_id' => 2]);

    /*
     * In the migrations generated_images.theme_id points at `themes`;
     * the live table points at photoshoot_themes.
     */
    DB::table('themes')->insert(['id' => 5, 'name' => 'Galaxy', 'slug' => 'galaxy']);
    DB::table('occasions')->insert(['id' => 2, 'status' => 'active']);

    DB::table('photo_frames')->insert([
        ['id' => 1, 'frame_name' => 'Gold', 'frame_path' => 'frames/gold.png', 'google_drive_file_id' => 'drive-gold'],
        ['id' => 2, 'frame_name' => 'Theme Frame', 'frame_path' => 'frames/theme.png', 'google_drive_file_id' => 'drive-theme'],
    ]);

    Storage::disk('public')->put('frames/gold.png', framePng());
    Storage::disk('public')->put('frames/theme.png', framePng());

    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [['content' => ['parts' => [['inlineData' => ['data' => base64_encode(framePng())]]]]]],
        ]),
    ]);

    $this->mock(GoogleDriveService::class, function ($mock) {
        $mock->shouldReceive('uploadImage')->andThrow(new Exception('Google Drive is not connected.'));
    });
});

function framePng(): string
{
    $image = imagecreatetruecolor(30, 20);
    ob_start();
    imagepng($image);
    imagedestroy($image);

    return (string) ob_get_clean();
}

function generateWithFrame($test, ?int $frameId)
{
    return $test->postJson(route('gemini.generate'), [
        'image' => 'data:image/jpeg;base64,'.base64_encode('guest-photo'),
        'theme_id' => 5,
        'frame_id' => $frameId,
    ]);
}

test('the frame the guest picked is saved as the chosen frame', function () {
    DB::table('booth_settings')->insert(['guests_can_pick_frame' => true]);

    generateWithFrame($this, 1)->assertOk()->assertJson(['frame_applied' => true, 'frame_id' => 1]);

    expect(GeneratedImage::sole())
        ->chosen_frame_id->toBe(1)
        ->applied_frame_path->toBe('frames/gold.png');
});

test('no chosen frame is saved when the guest did not pick one', function () {
    DB::table('booth_settings')->insert(['guests_can_pick_frame' => true]);

    generateWithFrame($this, null)->assertOk()->assertJson(['frame_id' => 2]);

    expect(GeneratedImage::sole()->chosen_frame_id)->toBeNull();
});

test('the guest pick is ignored when the admin site fixes the frame automatically', function () {
    DB::table('booth_settings')->insert(['guests_can_pick_frame' => false]);

    generateWithFrame($this, 1)->assertOk()->assertJson(['frame_id' => 2]);

    expect(GeneratedImage::sole())
        ->chosen_frame_id->toBeNull()
        ->applied_frame_path->toBe('frames/theme.png');
});

test('the framed photo is a landscape 4r print at 300 dpi', function () {
    generateWithFrame($this, null)->assertOk()->assertJson(['frame_applied' => true]);

    $finalPath = Storage::disk('public')->path(GeneratedImage::sole()->generated_photo_path);

    expect(array_slice(getimagesize($finalPath), 0, 2))->toBe([1800, 1200])
        ->and(imageresolution(imagecreatefrompng($finalPath)))->toBe([300, 300]);
});

test('the generated image without a frame is also a 6x4 print', function () {
    DB::table('photo_frames')->delete();

    generateWithFrame($this, null)->assertOk()->assertJson(['frame_applied' => false]);

    $generatedPath = Storage::disk('public')->path(GeneratedImage::sole()->generated_photo_path);

    expect(array_slice(getimagesize($generatedPath), 0, 2))->toBe([1800, 1200])
        ->and(imageresolution(imagecreatefrompng($generatedPath)))->toBe([300, 300]);
});

test('the generated image is cropped to 6x4 instead of being stretched', function () {
    $wideImage = imagecreatetruecolor(400, 100);
    imagefilledrectangle($wideImage, 0, 0, 99, 99, (int) imagecolorallocate($wideImage, 255, 0, 0));
    imagefilledrectangle($wideImage, 100, 0, 299, 99, (int) imagecolorallocate($wideImage, 0, 0, 255));
    imagefilledrectangle($wideImage, 300, 0, 399, 99, (int) imagecolorallocate($wideImage, 255, 0, 0));
    ob_start();
    imagepng($wideImage);

    $printPng = (new ReflectionMethod(GeminiController::class, 'fitToPrintSize'))
        ->invoke(new GeminiController, (string) ob_get_clean());

    $image = imagecreatefromstring($printPng);

    expect([imagesx($image), imagesy($image)])->toBe([1800, 1200]);

    /*
     * The centre 150x100 (blue) is kept; the red sides are cropped off.
     */
    expect(imagecolorsforindex($image, imagecolorat($image, 5, 600)))->toMatchArray(['red' => 0, 'blue' => 255])
        ->and(imagecolorsforindex($image, imagecolorat($image, 1794, 600)))->toMatchArray(['red' => 0, 'blue' => 255]);
});

test('gemini is asked for a 3:2 landscape image', function () {
    generateWithFrame($this, null)->assertOk();

    Http::assertSent(fn ($request) => $request['generationConfig']['imageConfig']['aspectRatio'] === '3:2');
});

test('the frame page is skipped when the admin site fixes the frame automatically', function () {
    DB::table('booth_settings')->insert(['guests_can_pick_frame' => false]);

    $this->get(route('photobooth.frame', ['theme_id' => 5]))
        ->assertRedirect(route('photobooth.create', ['theme_id' => 5]));
});
