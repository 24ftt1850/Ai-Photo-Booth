<?php

test('first visit to the home page shows the setup page first', function () {
    $this->get(route('home'))->assertRedirect(route('setup'));
});

test('setup page asks for the ip address and then shows event options', function () {
    $this->get(route('setup'))
        ->assertOk()
        ->assertSeeInOrder(['IP ADDRESS', 'id="ipAddress"', 'Choose Event', 'data-event="wedding"', 'CONTINUE'], false)
        ->assertSee('action="'.route('setup.complete').'"', false);
});

test('completing setup remembers it and goes to the welcome page', function () {
    $this->post(route('setup.complete'))
        ->assertRedirect(route('home'))
        ->assertCookie('rupavue_setup_complete', '1');
});

test('after setup the home page is not sent back to setup', function () {
    $response = $this->withCookie('rupavue_setup_complete', '1')->get(route('home'));

    expect($response->isRedirect(route('setup')))->toBeFalse();
});
