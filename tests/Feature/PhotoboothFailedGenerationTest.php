<?php

use App\Models\GeneratedImage;
use App\Models\PhotoSession;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Client\ConnectionException;
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
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });

    Schema::create('occasions', function (Blueprint $table) {
        $table->id();
        $table->string('status');
    });

    Schema::create('theme_reference_images', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('theme_id');
        $table->string('local_path')->nullable();
        $table->string('google_drive_file_id')->nullable();
        $table->integer('sort_order')->default(0);
        $table->boolean('is_active')->default(true);
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
        $table->text('final_prompt_used')->nullable();
        $table->string('generation_status')->nullable();
        $table->string('failure_reason', 500)->nullable();
    });

    DB::table('photoshoot_themes')->insert(['id' => 5, 'theme_name' => 'Galaxy', 'prompt_prefix' => 'A galaxy portrait']);

    /*
     * In the migrations generated_images.theme_id points at `themes`;
     * the live table points at photoshoot_themes.
     */
    DB::table('themes')->insert(['id' => 5, 'name' => 'Galaxy', 'slug' => 'galaxy']);
    DB::table('occasions')->insert(['id' => 2, 'status' => 'active']);
});

function generatePhoto($test)
{
    return $test->postJson(route('gemini.generate'), [
        'image' => 'data:image/jpeg;base64,'.base64_encode('guest-photo'),
        'theme_id' => 5,
    ]);
}

test('a gemini error is saved as a failed generation with its reason', function () {
    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response(['error' => ['message' => 'Quota exceeded for this project.']], 429),
    ]);

    generatePhoto($this)->assertStatus(500)->assertJson(['success' => false]);

    $failure = GeneratedImage::sole();

    expect($failure->generation_status)->toBe('failed_other')
        ->and($failure->failure_reason)->toBe('Gemini returned HTTP 429: Quota exceeded for this project.')
        ->and($failure->theme_id)->toBe(5);

    $session = PhotoSession::find($failure->photo_session_id);

    expect($session->session_code)->toStartWith('PS-')
        ->and($session->occasion_id)->toBe(2)
        ->and($session->status)->toBe('abandoned');
});

test('a photo blocked by the safety filter is saved as nsfw', function () {
    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [[
                'finishReason' => 'IMAGE_SAFETY',
                'content' => ['parts' => [['text' => 'I cannot edit this photo.']]],
            ]],
        ]),
    ]);

    generatePhoto($this)->assertStatus(500);

    expect(GeneratedImage::sole())
        ->generation_status->toBe('failed_nsfw')
        ->failure_reason->toBe('Gemini did not return an image (IMAGE_SAFETY): I cannot edit this photo..');
});

test('a gemini reply without an image tells the booth so and is saved once', function () {
    Http::fake([
        'generativelanguage.googleapis.com/*' => Http::response([
            'candidates' => [[
                'finishReason' => 'STOP',
                'content' => ['parts' => [['text' => 'The photo is just a plain black image.']]],
            ]],
        ]),
    ]);

    generatePhoto($this)
        ->assertStatus(500)
        ->assertJson(['success' => false, 'message' => 'Gemini did not return an image.']);

    expect(GeneratedImage::sole())
        ->generation_status->toBe('failed_other')
        ->failure_reason->toBe('Gemini did not return an image (STOP): The photo is just a plain black image..');
});

test('a gemini timeout is saved as timed out', function () {
    Http::fake(fn () => throw new ConnectionException('cURL error 28: Operation timed out'));

    generatePhoto($this)->assertStatus(504)->assertJson(['success' => false]);

    expect(GeneratedImage::sole())
        ->generation_status->toBe('failed_timeout')
        ->failure_reason->toBe('Gemini did not respond in time: cURL error 28: Operation timed out');
});
