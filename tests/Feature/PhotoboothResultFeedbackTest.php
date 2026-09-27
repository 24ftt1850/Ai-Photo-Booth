<?php

test('result page submits feedback by tapping an emoji without a submit button', function () {
    $view = $this->view('photobooth.result', ['photoFrames' => collect()]);

    $view->assertSee('data-rating="5"', false)
        ->assertSee('submitRating()', false)
        ->assertDontSee('id="submitFeedback"', false)
        ->assertDontSee('Submit Feedback');
});

test('result page lets the guest change their rating after submitting it', function () {
    $html = (string) $this->view('photobooth.result', ['photoFrames' => collect()]);

    expect($html)->toContain('Thank you for your feedback! ❤️')
        ->not->toContain('Tap another emoji to change it.')
        ->toContain('let savedRating = 0;')
        ->toContain('ratingChangedWhileSaving')
        ->toMatch('/if \(selectedRating === savedRating\) \{\s*return;/')
        ->not->toMatch('/item\.disabled\s*=\s*true;/')
        ->not->toMatch('/if \(\s*!selectedRating \|\|\s*feedbackSubmitted/');
});

test('result page shows the qr code beside the photo instead of in a popup', function () {
    $view = $this->view('photobooth.result', ['photoFrames' => collect()]);

    $view->assertSeeInOrder(['class="result-frame"', 'class="qr-panel"', 'id="qrCode"'], false)
        ->assertDontSee('id="qrModalOverlay"', false)
        ->assertDontSee('id="qrIconButton"', false);
});

test('result page stacks the feedback and action buttons underneath the qr code beside the photo', function () {
    $view = $this->view('photobooth.result', ['photoFrames' => collect()]);

    $view->assertSeeInOrder([
        'class="photo-qr-section"',
        'class="result-frame"',
        'class="qr-feedback-column"',
        'class="qr-panel"',
        'class="feedback-card"',
        'class="bottom-actions"',
        'id="printButton"',
        'id="newSessionButton"',
        '</section>',
    ], false);
});

test('generate page fades out before going to the result page, which animates in', function () {
    $this->view('photobooth.generate', ['theme' => null, 'photoFrames' => collect()])
        ->assertSee('.generate-page.is-leaving', false)
        ->assertSeeInOrder([".add('is-leaving')", 'await wait(600)', 'window.location.href'], false);

    $this->view('photobooth.result', ['photoFrames' => collect()])
        ->assertSee('animation: resultPhotoReveal', false)
        ->assertSee('animation: resultSlideIn', false);
});

test('generate page flashes white into the result page, which reveals itself from the flash', function () {
    $this->view('photobooth.generate', ['theme' => null, 'photoFrames' => collect()])
        ->assertSee('id="rvFlash"', false)
        ->assertSee('class="rv-flash-bloom"', false)
        ->assertSeeInOrder([
            "flash.classList.add('active')",
            "sessionStorage.setItem('rupavueFlashIn', '1')",
            'await wait(600)',
            'window.location.href',
        ], false);

    $this->view('photobooth.result', ['photoFrames' => collect()])
        ->assertSee('html:not(.rv-flash-in) .rv-flash', false)
        ->assertSee('animation: rvFlashBloomOut', false)
        ->assertSee('html.rv-flash-in .result-frame', false)
        ->assertSeeInOrder([
            "sessionStorage.getItem('rupavueFlashIn')",
            "sessionStorage.removeItem('rupavueFlashIn')",
            "classList.add('rv-flash-in')",
            '</head>',
            'id="rvFlash"',
        ], false);
});

test('generate page shows bigger, raised your photo and ai result labels', function () {
    $html = (string) $this->view('photobooth.generate', ['theme' => null, 'photoFrames' => collect()]);

    expect($html)->toMatch('/\.photo-title \{[^}]*color: #ffffff;[^}]*font-size: 30px;[^}]*transform: translateY\(-16px\);/')
        ->toContain('Your Photo')
        ->toContain('AI Result');
});

test('generate page shows rupa in the middle between both photo frames', function () {
    $html = (string) $this->view('photobooth.generate', ['theme' => null, 'photoFrames' => collect()]);

    expect($html)->toMatch('/Your Photo.*<div class="rupa-character">.*<img\s+src="[^"]*images\/rupa-waiting\.png".*AI Result/s')
        ->toMatch('/\.generation-container \{[^}]*grid-template-columns: minmax\(0, 1fr\) clamp\(140px, 13vw, 240px\) minmax\(0, 1fr\);/')
        ->not->toContain('<div class="arrow">');
});

test('generate page shows an ai magic animation instead of a loading circle', function () {
    $html = (string) $this->view('photobooth.generate', ['theme' => null, 'photoFrames' => collect()]);

    expect($html)->toMatch('/AI Result.*<div class="photo-placeholder ai-magic-placeholder">\s*<!-- AI "creating" animation -->\s*<div class="ai-magic" id="aiMagic"/s')
        ->toContain('class="ai-magic-scan"')
        ->toContain('class="ai-magic-orb"')
        ->toMatch('/\.ai-magic-placeholder \{[^}]*animation: aiAurora /')
        ->toMatch('/\.ai-magic-scan \{[^}]*animation: aiScan /')
        ->toContain("aiMagic.style.display = 'none';")
        ->not->toContain('loading-circle')
        ->not->toContain('loadingCircle');
});

test('generate page shows the loading bar as rupa talking in a speech bubble', function () {
    $html = (string) $this->view('photobooth.generate', ['theme' => null, 'photoFrames' => collect()]);

    expect($html)->toMatch('/<div class="rupa-character">\s*<!-- Rupa "talks" the progress -->\s*<div class="rupa-speech" id="rupaSpeech"[^>]*>.*id="rupaSpeechText".*id="progressFill".*id="progressText".*<\/div>\s*<img\s+src="[^"]*rupa-waiting\.png"/s')
        ->toContain('async function rupaSay(message)')
        ->toMatch('/function updateProgress\([^)]*\)\s*\{.*?rupaSay\(message\);/s')
        ->toContain("rupaSay('Oh no! ' + message);")
        ->toMatch('/\.rupa-character \{[^}]*z-index: 5;/')
        ->toMatch('/\.rupa-speech \{[^}]*width: clamp\(260px, 22vw, 380px\);[^}]*padding: 18px 22px;/')
        ->toMatch('/\.rupa-speech-message \{[^}]*font-size: 20px;/')
        ->and(substr_count($html, 'id="progressFill"'))->toBe(1);
});
