<?php

namespace App\Models;

use Database\Factories\ThemeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $theme_name
 * @property string|null $description
 * @property string|null $thumbnail_path
 * @property string|null $thumbnail_local_path
 * @property int|null $photo_frame_id
 * @property string|null $google_drive_file_id
 * @property string|null $google_drive_url
 * @property string|null $google_drive_status
 * @property string $prompt_prefix
 * @property string|null $prompt_suffix
 * @property string|null $negative_prompt
 * @property bool|null $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read string|null $thumbnail_url
 */
class Theme extends Model
{
    /** @use HasFactory<ThemeFactory> */
    use HasFactory;

    /**
     * Categories assigned to this theme by the Admin Website.
     *
     * A theme can belong to multiple categories.
     *
     * @return BelongsToMany<ThemeCategory, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            ThemeCategory::class,
            'photoshoot_theme_category',
            'theme_id',
            'category_id'
        );
    }

    /**
     * How many of the most used themes are labelled popular.
     */
    public const POPULAR_LIMIT = 3;

    protected $table = 'photoshoot_themes';

    protected $fillable = [
        'theme_name',
        'description',
        'thumbnail_path',
        'prompt_prefix',
        'prompt_suffix',
        'negative_prompt',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Browser-loadable URL for the theme thumbnail.
     *
     * thumbnail_path may be a local storage path, a plain image URL,
     * or a Google Drive share link (which is an HTML page, not an image).
     */
    
    public function getThumbnailUrlAttribute(): ?string
    {
        // 1. Prefer Google Drive thumbnail, matching the Admin Website.
        if ($this->google_drive_file_id) {
            return 'https://drive.google.com/thumbnail?id='
                . $this->google_drive_file_id
                . '&sz=w1000';
        }

        // 2. Fall back to the local thumbnail.
        if ($this->thumbnail_local_path) {
            return asset('storage/' . ltrim($this->thumbnail_local_path, '/'));
        }

        // 3. Fall back to thumbnail_path.
        $path = $this->thumbnail_path;

        if (! $path) {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            if (
                preg_match('#drive\.google\.com/file/d/([\w-]+)#', $path, $matches)
                || preg_match('#drive\.google\.com/(?:open|uc)\?(?:.*&)?id=([\w-]+)#', $path, $matches)
            ) {
                return 'https://drive.google.com/thumbnail?id='
                    . $matches[1]
                    . '&sz=w1000';
            }

            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }


    /**
     * Whether the theme was added within the last 7 days.
     */
    public function isNew(): bool
    {
        return $this->created_at !== null
            && $this->created_at->greaterThanOrEqualTo(now()->subDays(7));
    }

    /**
     * Ids of the themes guests have generated the most photos with.
     *
     * @return Collection<int, int>
     */
    public static function popularThemeIds(int $limit = self::POPULAR_LIMIT): Collection
    {
        return GeneratedImage::query()
            ->select('theme_id')
            ->groupBy('theme_id')
            ->orderByRaw('count(*) desc')
            ->orderBy('theme_id')
            ->limit($limit)
            ->pluck('theme_id')
            ->map(fn (mixed $themeId): int => (int) $themeId);
    }

    /**
     * @return HasMany<GeneratedImage, $this>
     */
    public function generatedImages(): HasMany
    {
        return $this->hasMany(GeneratedImage::class, 'theme_id');
    }
}
