<?php

use App\Http\Controllers\GeminiController;
use App\Models\GeneratedImage;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/*
 * The live generated_images table has columns the migrations lack.
 */
beforeEach(function () {
    Schema::table('generated_images', function (Blueprint $table) {
        $table->string('generated_photo_path')->nullable();
    });

    Storage::fake('public');
});

function putPicture(string $path, int $daysOld): void
{
    Storage::disk('public')->put($path, 'image-bytes');

    touch(Storage::disk('public')->path($path), now()->subDays($daysOld)->getTimestamp());
}

test('it deletes ai pictures older than a week and keeps newer ones and raw photos', function () {
    putPicture('photobooth/generated_old.png', 8);
    putPicture('photobooth/final_old.png', 8);
    putPicture('photobooth/generated_new.png', 2);
    putPicture('photobooth/final_new.png', 2);
    putPicture('photobooth/original_old.jpg', 30);
    putPicture('photobooth-raw/original_old.jpg', 30);

    GeneratedImage::factory()->create([
        'theme_id' => null,
        'generated_photo_path' => 'photobooth/final_old.png',
        'google_drive_file_id' => 'drive-file',
    ]);

    $this->artisan('photobooth:prune-pictures')->assertSuccessful();

    Storage::disk('public')->assertMissing(['photobooth/generated_old.png', 'photobooth/final_old.png']);

    Storage::disk('public')->assertExists([
        'photobooth/generated_new.png',
        'photobooth/final_new.png',
        'photobooth/original_old.jpg',
        'photobooth-raw/original_old.jpg',
    ]);
});

test('it keeps old final pictures that are not on google drive yet', function () {
    putPicture('photobooth/final_not_uploaded.png', 10);

    GeneratedImage::factory()->create([
        'theme_id' => null,
        'generated_photo_path' => 'photobooth/final_not_uploaded.png',
        'google_drive_file_id' => null,
    ]);

    $this->artisan('photobooth:prune-pictures')
        ->expectsOutputToContain('Kept 1 final pictures that are not on Google Drive yet.')
        ->assertSuccessful();

    Storage::disk('public')->assertExists('photobooth/final_not_uploaded.png');
});

test('the prune command runs every day', function () {
    $events = collect(app(Schedule::class)->events())
        ->filter(fn ($event): bool => str_contains($event->command, 'photobooth:prune-pictures'));

    expect($events)->toHaveCount(1)
        ->and($events->first()->expression)->toBe('0 0 * * *');
});

test('raw camera photos are saved in their own folder', function () {
    expect(GeminiController::RAW_PHOTO_FOLDER)->toBe('photobooth-raw');

    expect(file_get_contents(app_path('Http/Controllers/GeminiController.php')))
        ->toContain("self::RAW_PHOTO_FOLDER.'/'.\$fileName")
        ->toContain("'raw_photo_path' => \$rawPhotoPath,")
        ->not->toContain("'photobooth/'.\$fileName");
});
