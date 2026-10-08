<?php

test('opening the link shows the setup page first', function () {
    $this->get(route('home'))->assertRedirect(route('setup'));
});

test('opening the link from another site shows the setup page first', function () {
    $this->withHeader('referer', 'https://example.com/booth')
        ->get(route('home'))
        ->assertRedirect(route('setup'));
});

test('setup page asks for the ip address and then shows event options', function () {
    $this->get(route('setup'))
        ->assertOk()
        ->assertSeeInOrder(['IP ADDRESS', 'id="ipAddress"', 'Choose Event', 'data-event="wedding"', 'CONTINUE'], false)
        ->assertSee('action="'.route('setup.complete').'"', false);
});

test('completing setup goes to the welcome page', function () {
    $this->post(route('setup.complete'))->assertRedirect(route('home'));
});

test('coming back to home from inside the booth is not sent to setup', function () {
    $response = $this->withHeader('referer', route('setup'))->get(route('home'));

    expect($response->isRedirect(route('setup')))->toBeFalse();
});
