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
