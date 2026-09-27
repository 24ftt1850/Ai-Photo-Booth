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

    expect($html)->toMatch('/\.selected-theme \{[^}]*margin-top: 30px;/')
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

test('camera page shows a bigger, glowing capture button with a spinning ring and ripple', function () {
    $html = (string) $this->view('photobooth.create', [
        'theme' => makeTheme(1, 'Camera Theme', '2026-09-01 12:00:00'),
        'photoFrames' => collect(),
    ]);

    expect($html)->toMatch('/\.capture-button \{[^}]*width: 104px;[^}]*height: 104px;[^}]*padding: 0 0 6px;[^}]*font-size: 42px;[^}]*radial-gradient/')
        ->toMatch('/\.capture-button::before \{[^}]*conic-gradient[^}]*animation: captureRingSpin /')
        ->toMatch('/\.capture-button::after \{[^}]*animation: captureRipple /')
        ->toMatch('/\.capture-button:disabled::before,\s*\.capture-button:disabled::after \{[^}]*animation: none;/')
        ->toContain('id="captureButton"');
});

test('camera page has a bigger frame, bigger lower title and theme label, and no subtitle', function () {
    $html = (string) $this->view('photobooth.create', [
        'theme' => makeTheme(1, 'Camera Theme', '2026-09-01 12:00:00'),
        'photoFrames' => collect(),
    ]);

    expect($html)->toContain('Strike a Pose')
        ->not->toContain('Get ready and capture your photo.')
        ->toMatch('/\.title-section \{[^}]*margin-top: 20px;/')
        ->toMatch('/\.title-section h1 \{[^}]*font-size: clamp\(46px, 6vw, 76px\);/')
        ->toMatch('/\.selected-theme span \{[^}]*padding: 12px 30px;[^}]*font-size: 21px;/')
        ->toMatch('/\.camera-frame \{[^}]*calc\(min\(74vh, 680px\) \* 1\.5\),\s*calc\(100vw - 600px\),\s*1040px/');
});

test('camera page requests a landscape stream matching the 3:2 frame so it is not zoomed', function () {
    $html = (string) $this->view('photobooth.create', [
        'theme' => makeTheme(1, 'Camera Theme', '2026-09-01 12:00:00'),
        'photoFrames' => collect(),
    ]);

    expect($html)->toMatch('/getUserMedia\(\{\s*video: \{[^}]*facingMode: \'user\'/')
        ->toMatch('/aspectRatio: \{\s*ideal: 3 \/ 2\s*\}/')
        ->not->toContain('ideal: 2 / 3');
});

test('camera page shows rupa character instead of the change theme button', function () {
    $html = (string) $this->view('photobooth.create', [
        'theme' => makeTheme(1, 'Camera Theme', '2026-09-01 12:00:00'),
        'photoFrames' => collect(),
    ]);

    expect($html)->toMatch('/class="side-controls">\s*<div class="rupa-character"/')
        ->toContain('images/rupa-pose.png')
        ->toMatch('/\.side-controls \{[^}]*width: 320px;/')
        ->not->toContain('Change Theme')
        ->not->toContain('backButton');
});

test('camera page shows rupa talking in a typed speech bubble', function () {
    $html = (string) $this->view('photobooth.create', [
        'theme' => makeTheme(1, 'Camera Theme', '2026-09-01 12:00:00'),
        'photoFrames' => collect(),
    ]);

    expect($html)->toMatch('/<div class="rupa-character"[^>]*>\s*<div class="rupa-speech" id="rupaSpeech">/')
        ->toContain('<span id="rupaSpeechText"></span><span class="rupa-speech-caret"></span>')
        ->toContain('Strike a pose!')
        ->toContain('async function typeRupaMessage(segments)')
        ->toContain("rupaSpeech.classList.add('visible');")
        ->toMatch('/await typeRupaMessage\(rupaMessages\[index\]\);\s*await rupaWait\(4500\);/')
        ->toContain('startRupaTalking();');
});

test('camera page plays a shutter click when the photo is taken', function () {
    $html = (string) $this->view('photobooth.create', [
        'theme' => makeTheme(1, 'Camera Theme', '2026-09-01 12:00:00'),
        'photoFrames' => collect(),
    ]);

    expect($html)->toContain('function playShutterSound()')
        ->toMatch('/countdownRunning = true;[\s\S]*?unlockShutterSound\(\);/')
        ->toMatch('/function capturePhoto\(\) \{[\s\S]*?playShutterSound\(\);/');
});

test('next buttons across the photobooth flow play a click sound', function () {
    $pages = [
        'welcome' => [],
        'photobooth.scene' => ['themes' => collect(), 'photoFrames' => collect()],
        'photobooth.create' => ['theme' => makeTheme(1, 'Camera Theme', '2026-09-01 12:00:00'), 'photoFrames' => collect()],
        'photobooth.result' => ['photoFrames' => collect()],
    ];

    foreach ($pages as $page => $data) {
        expect((string) $this->view($page, $data))
            ->toContain('window.rupavueClickSound = (function () {');
    }

    expect((string) $this->view('welcome'))->toContain('window.rupavueClickSound.play();');
    expect((string) $this->view('photobooth.scene', $pages['photobooth.scene']))->toContain('window.rupavueClickSound.goTo(');
    expect((string) $this->view('photobooth.create', $pages['photobooth.create']))->toContain('window.rupavueClickSound.goTo(');
    expect((string) $this->view('photobooth.result', $pages['photobooth.result']))->toContain('window.rupavueClickSound.goTo(');
});

test('welcome page warps into the theme selection page', function () {
    $welcome = (string) $this->view('welcome');

    expect($welcome)->toContain('function startWarpTransition(originElement)')
        ->toContain('id="rvWarpStreaks"')
        ->toContain('class="rv-warp-iris"')
        ->toContain("sessionStorage.setItem('rupavueWarpIn', '1');");

    $scene = (string) $this->view('photobooth.scene', ['themes' => collect(), 'photoFrames' => collect()]);

    expect($scene)->toContain('id="rvWarpEnter"')
        ->toContain("sessionStorage.getItem('rupavueWarpIn')")
        ->toContain("document.documentElement.classList.add('rv-warp-in');")
        ->toMatch('/html\.rv-warp-in \.scene-header \{[^}]*animation-delay: 0\.45s;/');
});

test('theme page shows a bigger, white capture photo button with a blue shine and no blinking', function () {
    $html = (string) $this->view('photobooth.scene', ['themes' => collect(), 'photoFrames' => collect()]);

    expect($html)->toContain('CAPTURE PHOTO')
        ->toMatch('/\.next-button \{[^}]*min-width: 440px;[^}]*padding:\s*30px 64px;[^}]*#ffffff,\s*#dfe7f2[^}]*color: #0a2a5c;[^}]*font-size: 23px;[^}]*0 0 35px\s*rgba\(40,165,255,\.95\),\s*0 0 80px\s*rgba\(0,140,255,\.55\)/')
        ->toMatch('/\.next-button::before \{[^}]*rgba\(0,150,255,\.9\)/')
        ->toMatch('/\.next-button:not\(:disabled\):hover \{[^}]*0 0 50px\s*rgba\(60,180,255,1\),\s*0 0 110px\s*rgba\(0,140,255,\.65\)/')
        ->toMatch('/\.selection-area \{[^}]*gap: 78px;[^}]*padding-bottom: 58px;/')
        ->toMatch('/\.next-button:not\(:disabled\)::before \{[^}]*animation:\s*nextButtonShine /')
        ->toContain('@keyframes nextButtonShine')
        ->not->toContain('nextButtonGlow');
});

test('theme page shows a bigger, lower choose your theme heading', function () {
    expect((string) $this->view('photobooth.scene', ['themes' => collect(), 'photoFrames' => collect()]))
        ->toContain('Choose Your Theme')
        ->toMatch('/\.scene-header \{[^}]*margin-top: 24px;/')
        ->toMatch('/\.scene-header h1 \{[^}]*font-size:\s*clamp\(\s*38px,\s*5vw,\s*64px\s*\);/');
});

test('theme page does not show the select a theme subtitle', function () {
    expect((string) $this->view('photobooth.scene', ['themes' => collect(), 'photoFrames' => collect()]))
        ->toContain('Choose Your Theme')
        ->not->toContain('Select a theme for your AI photo transformation.');
});

test('welcome page does not show the professional studio tagline', function () {
    expect((string) $this->view('welcome'))
        ->toContain('UNFORGETTABLE AI ART')
        ->not->toContain('YOUR PROFESSIONAL STUDIO IN THE PALM OF YOUR HAND.');
});

test('welcome page centers the high council and street racer theme names', function () {
    expect((string) $this->view('welcome'))
        ->toContain('High Council')
        ->toContain('Street Racer')
        ->toMatch('/\.rv-theme-info \{[^}]*justify-content: center;[^}]*text-align: center;/');
});

test('welcome page has no ai powered footer and a lower start button', function () {
    expect((string) $this->view('welcome'))
        ->toContain('START SESSION')
        ->toMatch('/\.rv-cta-area \{[^}]*margin-top: 80px;/')
        ->not->toContain('AI POWERED PHOTO BOOTH')
        ->not->toContain('rv-footer');
});

test('welcome page animates the rupa character', function () {
    expect((string) $this->view('welcome'))
        ->toContain('images/rupa-character.png')
        ->toMatch('/\.rupa-character \{[^}]*left: 70px;[^}]*bottom: 40px;[^}]*width: 290px;/')
        ->toMatch('/\.rupa-character \{[^}]*animation:\s*rupaEnter [^;]*,\s*rupaSway [^;]*infinite;/')
        ->toMatch('/\.rupa-character img \{[^}]*animation: rupaFloat [^;]*infinite;/')
        ->toContain('@keyframes rupaShadow')
        ->toMatch('/\.rupa-character img \{[^}]*will-change: translate, scale;/')
        ->not->toMatch('/\.rupa-character img \{[^}]*filter:/');
});

test('rupa character talks and tells the guest to press start session', function () {
    expect((string) $this->view('welcome'))
        ->toContain('id="rupaSpeech"')
        ->toContain('id="rupaSpeechText"')
        ->toContain("[['Tap '], ['START SESSION', 'rupa-speech-highlight'], [' to begin!']]")
        ->toContain('async function startRupaTalking()')
        ->toMatch('/\.rupa-speech\.visible \{[^}]*opacity: 1;/')
        ->toMatch('/\.rupa-speech \{[^}]*--rupa-speech-left: 42%;[^}]*bottom: var\(--rupa-speech-bottom\);[^}]*left: var\(--rupa-speech-left\);[^}]*max-width: var\(--rupa-speech-max\);[^}]*font-size: 20px;/')
        ->toContain('function fitRupaSpeech()')
        ->toContain("window.addEventListener('resize', fitRupaSpeech);")
        ->toMatch('/fitRupaSpeech\(\);\s*rupaSpeechText\.innerHTML = \'\';\s*rupaSpeech\.classList\.add\(\'visible\'\);/');
});

test('welcome start button is white with a blinking blue glow', function () {
    expect((string) $this->view('welcome'))
        ->toMatch('/\.rv-start-button \{[^}]*border: 2px solid #ffffff;[^}]*#ffffff 0%,[^}]*color: #06255e;/')
        ->toMatch('/\.rv-start-button::before \{[^}]*animation: rvStartGlowBlink [^;]*infinite;/')
        ->toMatch('/\.rv-start-button::after \{[^}]*animation: rvStartRingBlink [^;]*infinite;/')
        ->toContain('@keyframes rvStartGlowBlink')
        ->toContain('@keyframes rvStartRingBlink');
});
