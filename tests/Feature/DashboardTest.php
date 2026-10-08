<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users are sent back to the photobooth', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('home'));
});

test('logging in lands on the photobooth instead of a missing page', function () {
    $this->actingAs(User::factory()->create())
        ->get(config('fortify.home'))
        ->assertRedirect(route('home'));
});
