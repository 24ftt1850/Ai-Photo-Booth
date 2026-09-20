<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
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

        if (!$path) {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            if (preg_match('#drive\.google\.com/file/d/([\w-]+)#', $path, $m)
                || preg_match('#drive\.google\.com/(?:open|uc)\?(?:.*&)?id=([\w-]+)#', $path, $m)) {
                return 'https://drive.google.com/thumbnail?id=' . $m[1] . '&sz=w1000';
            }

            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    public function generatedImages()
    {
        return $this->hasMany(GeneratedImage::class, 'theme_id');
    }
}