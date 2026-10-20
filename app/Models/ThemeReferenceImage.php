<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ThemeReferenceImage extends Model
{
    protected $table = 'theme_reference_images';

    protected $fillable = [
        'theme_id',
        'local_path',
        'original_name',
        'caption',
        'sort_order',
        'is_active',
        'google_drive_file_id',
        'google_drive_url',
        'google_drive_status',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }

    public function localUrl(): ?string
    {
        return $this->local_path
            ? Storage::disk('public')->url($this->local_path)
            : null;
    }

    public function previewUrl(int $width = 640): ?string
    {
        if ($this->google_drive_file_id) {
            return 'https://drive.google.com/thumbnail?id='
                . $this->google_drive_file_id
                . '&sz=w' . $width;
        }

        return $this->localUrl();
    }

    public function url(): ?string
    {
        return $this->previewUrl();
    }
}
