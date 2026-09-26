<?php

test('result page submits feedback by tapping an emoji without a submit button', function () {
    $view = $this->view('photobooth.result', ['photoFrames' => collect()]);

    $view->assertSee('data-rating="5"', false)
        ->assertSee('submitRating()', false)
        ->assertDontSee('id="submitFeedback"', false)
        ->assertDontSee('Submit Feedback');
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

    expect($html)->toMatch('/\.photo-title \{[^}]*font-size: 22px;[^}]*transform: translateY\(-8px\);/')
        ->toContain('Your Photo')
        ->toContain('AI Result');
});
