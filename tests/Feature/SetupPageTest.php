<?php

use App\Services\GoogleDriveService;
use Carbon\CarbonImmutable;

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

test('setup page offers to connect google drive', function () {
    $this->mock(GoogleDriveService::class, function ($mock) {
        $mock->shouldReceive('isConnected')->andReturnFalse();
        $mock->shouldReceive('usesSharedToken')->andReturnFalse();
        $mock->shouldReceive('reconnectDeadline')->andReturnNull();
    });

    $this->get(route('setup'))
        ->assertOk()
        ->assertSee('Not connected')
        ->assertSee('CONNECT GOOGLE DRIVE')
        ->assertSee(route('google-drive.connect', ['from' => 'setup']), false)
        ->assertDontSee('Reconnect within');
});

test('setup page shows the time left before google drive must be reconnected', function () {
    $this->mock(GoogleDriveService::class, function ($mock) {
        $mock->shouldReceive('isConnected')->andReturnTrue();
        $mock->shouldReceive('usesSharedToken')->andReturnFalse();
        $mock->shouldReceive('reconnectDeadline')->andReturn(CarbonImmutable::parse('2026-10-18 09:00:00'));
    });

    $this->get(route('setup', ['result' => 'connected']))
        ->assertOk()
        ->assertSee('Connected')
        ->assertSee('Generated photos will now be saved to Drive.')
        ->assertSee('RECONNECT GOOGLE DRIVE')
        ->assertSee('Reconnect within')
        ->assertSee('data-reconnect-deadline="2026-10-18T09:00:00+00:00"', false);
});
