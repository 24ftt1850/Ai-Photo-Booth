<?php

test('returns a successful response', function () {
    $response = $this->withCookie('rupavue_setup_complete', '1')->get(route('home'));

    $response->assertOk();
});
