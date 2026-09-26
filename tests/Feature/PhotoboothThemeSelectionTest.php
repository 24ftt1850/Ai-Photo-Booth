<?php

use App\Models\Theme;

/**
 * Build an unsaved theme; the photoshoot_themes table has no migration,
 * so these tests render the view with in-memory models.
 */
function makeTheme(int $id, string $name, string $createdAt): Theme
{
    $theme = new Theme(['theme_name' => $name, 'is_active' => true]);
    $theme->id = $id;
    $theme->created_at = $createdAt;

    return $theme;
}

test('a theme counts as new only when added within the last 7 days', function () {
    $this->travelTo('2026-09-25 12:00:00');

    expect(makeTheme(1, 'Fresh', '2026-09-20 12:00:00')->isNew())->toBeTrue()
        ->and(makeTheme(2, 'Old', '2026-09-10 12:00:00')->isNew())->toBeFalse()
        ->and((new Theme)->isNew())->toBeFalse();
});

test('scene page shows a new badge only on recently added themes', function () {
    $this->travelTo('2026-09-25 12:00:00');

    $view = $this->view('photobooth.scene', [
        'themes' => collect([
            makeTheme(1, 'Old Theme', '2026-09-01 12:00:00'),
            makeTheme(2, 'Fresh Theme', '2026-09-24 12:00:00'),
        ]),
        'photoFrames' => collect(),
    ]);

    $view->assertSeeInOrder([
        'data-theme-name="Old Theme"',
        'data-theme-name="Fresh Theme"',
        'class="theme-new-badge"',
    ], false);

    expect(substr_count((string) $view, 'class="theme-new-badge"'))->toBe(1);
});

test('scene controller lists themes oldest first so new ones appear on the right', function () {
    $source = file_get_contents(app_path('Http/Controllers/PhotoboothController.php'));

    expect($source)->toContain("->orderBy('created_at')")
        ->not->toContain("->orderBy('theme_name')");
});

test('scene page lets guests swipe the theme track left and right', function () {
    $view = $this->view('photobooth.scene', [
        'themes' => collect([makeTheme(1, 'Only Theme', '2026-09-01 12:00:00')]),
        'photoFrames' => collect(),
    ]);

    $view->assertSee('touch-action: pan-y', false)
        ->assertSeeInOrder([
            "themeTrack.addEventListener(\n        'pointerdown'",
            "themeTrack.addEventListener(\n        'pointerup'",
            'currentIndex + 1',
            'currentIndex - 1',
            'selectTheme(targetIndex)',
        ], false);
});

test('scene page uses a larger selected theme box with larger text', function () {
    $html = (string) $this->view('photobooth.scene', ['themes' => collect(), 'photoFrames' => collect()]);

    expect($html)->toMatch('/\.action-bar \{[^}]*min-height: 84px;/')
        ->toMatch('/\.selected-info \{[^}]*font-size: 20px;/')
        ->toMatch('/\.selected-info strong \{[^}]*font-size: 24px;/')
        ->toMatch('/\.selected-description \{[^}]*font-size: 19px;/');
});

test('camera page pushes the selected theme label down a little', function () {
    $html = (string) $this->view('photobooth.create', [
        'theme' => makeTheme(1, 'Camera Theme', '2026-09-01 12:00:00'),
        'photoFrames' => collect(),
    ]);

    expect($html)->toMatch('/\.selected-theme \{[^}]*margin-top: 18px;/')
        ->toContain('Camera Theme');
});

test('camera page shows bigger, wider retake and continue buttons', function () {
    $html = (string) $this->view('photobooth.create', [
        'theme' => makeTheme(1, 'Camera Theme', '2026-09-01 12:00:00'),
        'photoFrames' => collect(),
    ]);

    expect($html)->toMatch('/\.side-controls-right \{[^}]*width: 260px;/')
        ->toMatch('/\.retake-button,\s*\.continue-button \{[^}]*padding: 34px 18px;[^}]*font-size: 21px;/')
        ->toContain('id="retakeButton"')
        ->toContain('id="continueButton"');
});

test('camera page shows a bigger capture button', function () {
    $html = (string) $this->view('photobooth.create', [
        'theme' => makeTheme(1, 'Camera Theme', '2026-09-01 12:00:00'),
        'photoFrames' => collect(),
    ]);

    expect($html)->toMatch('/\.capture-button \{[^}]*width: 96px;[^}]*height: 96px;[^}]*padding: 0 0 6px;[^}]*font-size: 40px;/')
        ->toContain('id="captureButton"');
});
