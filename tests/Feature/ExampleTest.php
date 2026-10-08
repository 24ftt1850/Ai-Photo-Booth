<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
 * photo_frames belongs to the RupaVue admin site's database and has
 * no migration here, so create it for the welcome page's frame list.
 */
beforeEach(function () {
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
});

test('returns a successful response', function () {
    $response = $this->withHeader('referer', route('setup'))->get(route('home'));

    $response->assertOk();
});

test('welcome page does not show the feature highlights', function () {
    $response = $this->withHeader('referer', route('setup'))->get(route('home'));

    $response->assertOk()
        ->assertDontSee('INSTANT GENERATION')
        ->assertDontSee('UNIQUE THEMES')
        ->assertDontSee('HD DOWNLOADS');
});

test('welcome page shows the rupa character image', function () {
    $response = $this->withHeader('referer', route('setup'))->get(route('home'));

    $response->assertOk()
        ->assertSee('images/rupa-character.png')
        ->assertDontSee('images/rupa-welcome.mp4');
});

test('the temporary frame diagnostic route is not exposed', function () {
    $this->get('/test-frame')->assertNotFound();
});
