<?php

use App\Models\PhotoFrame;
use App\Models\Theme;

/**
 * Build unsaved models; the photo_frames and photoshoot_themes
 * tables have no migration, so these tests render views in memory.
 */
function makeFrame(int $id, string $name, string $driveFileId): PhotoFrame
{
    $frame = new PhotoFrame([
        'frame_name' => $name,
        'frame_path' => 'frames/missing.png',
        'google_drive_file_id' => $driveFileId,
        'is_active' => true,
    ]);
    $frame->id = $id;

    return $frame;
}

function makeFrameTheme(): Theme
{
    $theme = new Theme(['theme_name' => 'Galaxy', 'is_active' => true]);
    $theme->id = 7;

    return $theme;
}

test('frame page lists the active google drive frames and continues to the capture page', function () {
    $html = (string) $this->view('photobooth.frame', [
        'theme' => makeFrameTheme(),
        'frames' => collect([
            makeFrame(1, 'Gold Border', 'drive-gold'),
            makeFrame(2, 'Neon Border', 'drive-neon'),
        ]),
    ]);

    expect($html)->toContain('Choose Your Frame')
        ->toContain('data-frame-id="1"')
        ->toContain('data-frame-id="2"')
        ->toContain('Gold Border')
        ->toContain('https://drive.google.com/thumbnail?id=drive-gold')
        ->toContain("sessionStorage.setItem('rupavueFrameId'")
        ->toContain(json_encode(route('photobooth.create', ['theme_id' => 7])));
});

test('frame preview falls back to the google drive thumbnail when the local file is missing', function () {
    expect(makeFrame(1, 'Gold', 'abc123')->previewUrl())
        ->toBe('https://drive.google.com/thumbnail?id=abc123&sz=w1000');
});

test('theme page goes to the frame page instead of straight to capture', function () {
    $html = (string) $this->view('photobooth.scene', ['themes' => collect(), 'photoFrames' => collect()]);

    expect($html)->toContain(route('photobooth.frame'))
        ->not->toContain("'".route('photobooth.create')."'")
        ->toContain('CHOOSE FRAME');
});

test('generate page sends the chosen frame to the generator', function () {
    $html = (string) $this->view('photobooth.generate', ['theme' => null, 'photoFrames' => collect()]);

    expect($html)->toContain("sessionStorage.getItem('rupavueFrameId')");
});

test('frame page requires a theme', function () {
    $this->get(route('photobooth.frame'))
        ->assertRedirect(route('photobooth.scene'));
})->skip(fn () => ! Schema::hasTable('photoshoot_themes'), 'photoshoot_themes has no migration');
