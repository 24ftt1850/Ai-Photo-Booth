<?php

use App\Models\GeneratedImage;
use App\Services\GoogleDriveService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Sleep;

/*
 * The booth writes to tables owned by the RupaVue admin site; shape the
 * test database like the live one for the columns the generator uses.
 */
beforeEach(function () {
    Storage::fake('public');
    Sleep::fake();

    config()->set('services.ai.provider', 'flux');
    config()->set('services.bfl.api_key', 'test-bfl-key');
    config()->set('services.bfl.model', 'flux-2-pro');

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
        $table->string('failure_reason', 500)->nullable();
        $table->string('generated_photo_path')->nullable();
        $table->string('applied_frame_path')->nullable();
    });

    DB::table('photoshoot_themes')->insert(['id' => 5, 'theme_name' => 'Galaxy', 'prompt_prefix' => 'A galaxy portrait']);

    /*
     * In the migrations generated_images.theme_id points at `themes`;
     * the live table points at photoshoot_themes.
     */
    DB::table('themes')->insert(['id' => 5, 'name' => 'Galaxy', 'slug' => 'galaxy']);
    DB::table('occasions')->insert(['id' => 2, 'status' => 'active']);

    $this->mock(GoogleDriveService::class, function ($mock) {
        $mock->shouldReceive('uploadImage')->andThrow(new Exception('Google Drive is not connected.'));
    });
});

function fluxTestPng(): string
{
    $image = imagecreatetruecolor(30, 20);
    ob_start();
    imagepng($image);
    imagedestroy($image);

    return (string) ob_get_clean();
}

function generateFluxPhoto($test)
{
    return $test->postJson(route('gemini.generate'), [
        'image' => 'data:image/jpeg;base64,'.base64_encode('guest-photo'),
        'theme_id' => 5,
    ]);
}

/**
 * @param  array<int, array<string, mixed>>  $pollReplies
 */
function fakeFlux(array $pollReplies): void
{
    $polls = Http::sequence();

    foreach ($pollReplies as $reply) {
        $polls->push($reply);
    }

    Http::fake([
        'api.bfl.ai/v1/flux-2-pro' => Http::response(['id' => 'job-1', 'polling_url' => 'https://api.bfl.ai/v1/get_result?id=job-1']),
        'api.bfl.ai/v1/get_result*' => $polls,
        'delivery.bfl.ai/*' => Http::response(fluxTestPng()),
    ]);
}

test('flux restyles the photo and the booth saves the downloaded image', function () {
    fakeFlux([
        ['status' => 'Pending'],
        ['status' => 'Ready', 'result' => ['sample' => 'https://delivery.bfl.ai/job-1.png']],
    ]);

    generateFluxPhoto($this)->assertOk()->assertJson(['success' => true]);

    Http::assertSent(fn (Request $request) => $request->url() === 'https://api.bfl.ai/v1/flux-2-pro'
        && $request->hasHeader('x-key', 'test-bfl-key')
        && $request['input_image'] === base64_encode('guest-photo')
        && $request['prompt'] === 'A galaxy portrait');

    Http::assertNotSent(fn (Request $request) => str_contains($request->url(), 'generativelanguage.googleapis.com'));

    expect(Storage::disk('public')->files('photobooth'))->toHaveCount(2);
});

test('a photo blocked by flux moderation is saved as nsfw', function () {
    fakeFlux([['status' => 'Content Moderated']]);

    generateFluxPhoto($this)->assertStatus(500)->assertJson(['success' => false]);

    expect(GeneratedImage::sole())
        ->generation_status->toBe('failed_nsfw')
        ->failure_reason->toBe('FLUX did not return an image (Content Moderated).');
});

test('running out of flux credits is saved with its reason and tells staff', function () {
    Http::fake([
        'api.bfl.ai/*' => Http::response(['detail' => 'Insufficient credits'], 402),
    ]);

    generateFluxPhoto($this)
        ->assertStatus(500)
        ->assertJson(['message' => 'The AI service is out of credits. Please ask a staff member for help.']);

    expect(GeneratedImage::sole())
        ->generation_status->toBe('failed_other')
        ->failure_reason->toBe('FLUX returned HTTP 402: Insufficient credits');
});

test('a flux job that never finishes is saved as timed out', function () {
    fakeFlux(array_fill(0, 120, ['status' => 'Pending']));

    generateFluxPhoto($this)->assertStatus(504);

    expect(GeneratedImage::sole())
        ->generation_status->toBe('failed_timeout')
        ->failure_reason->toBe('FLUX did not finish the image within two minutes.');
});

test('a missing flux api key is reported without calling the api', function () {
    config()->set('services.bfl.api_key', null);
    Http::fake();

    generateFluxPhoto($this)->assertStatus(500)->assertJson(['message' => 'FLUX API key is not configured.']);

    Http::assertNothingSent();
});
