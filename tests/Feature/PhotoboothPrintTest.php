<?php

use App\Models\GeneratedImage;
use App\Models\User;

/*
 * theme_id is null because the photoshoot_themes table has no migration.
 */

test('guest print request queues the photo for the admin instead of printing locally', function () {
    $generatedImage = GeneratedImage::factory()->create(['theme_id' => null]);

    $this->postJson(route('photobooth.print.store'), ['generated_image_id' => $generatedImage->id])
        ->assertOk()
        ->assertJson(['success' => true]);

    $generatedImage->refresh();

    expect($generatedImage->print_status)->toBe('queued')
        ->and($generatedImage->print_requested_at)->not->toBeNull();
});

test('guest print request requires an existing photo', function () {
    $this->postJson(route('photobooth.print.store'), ['generated_image_id' => 999])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('generated_image_id');
});

test('result page sends the photo to the print queue rather than opening a print window', function () {
    $html = (string) $this->view('photobooth.result', ['photoFrames' => collect()]);

    expect($html)->toContain(route('photobooth.print.store'))
        ->not->toContain('printWindow.print()');
});

test('admin sees queued prints and can mark them as printed', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $queued = GeneratedImage::factory()->create(['theme_id' => null, 'print_status' => 'queued', 'print_requested_at' => now()]);
    $notQueued = GeneratedImage::factory()->create(['theme_id' => null]);

    $this->actingAs($admin)
        ->get(route('admin.prints.index'))
        ->assertOk()
        ->assertSee("Photo #{$queued->id}")
        ->assertDontSee("Photo #{$notQueued->id}");

    $this->actingAs($admin)
        ->patch(route('admin.prints.printed', $queued))
        ->assertRedirect();

    $queued->refresh();

    expect($queued->print_status)->toBe('printed')
        ->and($queued->printed_at)->not->toBeNull();
});

test('admin can remove a print request', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $queued = GeneratedImage::factory()->create(['theme_id' => null, 'print_status' => 'queued', 'print_requested_at' => now()]);

    $this->actingAs($admin)
        ->delete(route('admin.prints.destroy', $queued))
        ->assertRedirect();

    expect($queued->refresh()->print_status)->toBeNull();
});

test('non-admins cannot view the print queue', function () {
    $this->actingAs(User::factory()->create(['role' => 'user']))
        ->get(route('admin.prints.index'))
        ->assertForbidden();
});
