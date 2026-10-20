<?php

namespace App\Console\Commands;

use App\Models\GeneratedImage;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Throwable;

#[Signature('photobooth:prune-pictures {--days=7 : Delete AI pictures older than this many days}')]
#[Description('Delete AI generated pictures in storage/app/public/photobooth older than a week (raw camera photos are kept)')]
class PrunePhotoboothPictures extends Command
{
    private const FOLDER = 'photobooth';

    /**
     * Delete old generated_* and final_* pictures. A final picture is
     * only deleted once it has a copy on Google Drive, so a photo is
     * never lost when the upload failed.
     */
    public function handle(): int
    {
        $disk = Storage::disk('public');

        $cutoff = now()->subDays((int) $this->option('days'))->getTimestamp();

        $oldPictures = collect($disk->files(self::FOLDER))
            ->filter(fn (string $path): bool => $this->isAiPicture($path))
            ->filter(fn (string $path): bool => $disk->lastModified($path) < $cutoff)
            ->values();

        $finalsWithoutDriveCopy = $this->finalsWithoutDriveCopy(
            $oldPictures->filter(fn (string $path): bool => str_starts_with(basename($path), 'final_'))->all()
        );

        $deletable = $oldPictures->reject(fn (string $path): bool => in_array($path, $finalsWithoutDriveCopy, true));

        $disk->delete($deletable->all());

        $this->info("Deleted {$deletable->count()} AI pictures older than {$this->option('days')} days.");

        if ($finalsWithoutDriveCopy !== []) {
            $this->warn('Kept '.count($finalsWithoutDriveCopy).' final pictures that are not on Google Drive yet.');
        }

        return self::SUCCESS;
    }

    private function isAiPicture(string $path): bool
    {
        $name = basename($path);

        return str_starts_with($name, 'generated_') || str_starts_with($name, 'final_');
    }

    /**
     * @param  array<int, string>  $finalPaths
     * @return array<int, string>
     */
    private function finalsWithoutDriveCopy(array $finalPaths): array
    {
        if ($finalPaths === []) {
            return [];
        }

        try {
            $onDrive = GeneratedImage::query()
                ->whereIn('generated_photo_path', $finalPaths)
                ->whereNotNull('google_drive_file_id')
                ->pluck('generated_photo_path')
                ->all();
        } catch (Throwable $exception) {
            /*
             * Without the database we cannot tell which photos are
             * safe on Drive, so keep every final picture this time.
             */
            $this->warn('Could not check Google Drive uploads: '.$exception->getMessage());

            return $finalPaths;
        }

        return array_values(array_diff($finalPaths, $onDrive));
    }
}
