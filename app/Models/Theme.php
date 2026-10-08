<?php

namespace App\Models;

use Database\Factories\ThemeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

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
        $path = $this->thumbnail_path;

        if (! $path) {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            if (preg_match('#drive\.google\.com/file/d/([\w-]+)#', $path, $m)
                || preg_match('#drive\.google\.com/(?:open|uc)\?(?:.*&)?id=([\w-]+)#', $path, $m)) {
                return 'https://drive.google.com/thumbnail?id='.$m[1].'&sz=w1000';
            }

            return $path;
        }

        return asset('storage/'.ltrim($path, '/'));
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
     * @return HasMany<GeneratedImage, $this>
     */
    public function generatedImages(): HasMany
    {
        return $this->hasMany(GeneratedImage::class, 'theme_id');
    }
}
