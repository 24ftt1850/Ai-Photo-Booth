<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * @property int $id
 * @property string $frame_name
 * @property string $frame_path
 * @property string|null $google_drive_file_id
 * @property string|null $google_drive_url
 * @property string|null $google_drive_status
 * @property string|null $description
 * @property bool|null $is_active
 * @property bool $is_default
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class PhotoFrame extends Model
{
    protected $table = 'photo_frames';

    protected $fillable = [
        'frame_name',
        'frame_path',
        'google_drive_file_id',
        'google_drive_url',
        'google_drive_status',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Frames guests can pick: active and stored in Google Drive,
     * since the frame is downloaded from Drive when it is applied.
     *
     * @param  Builder<PhotoFrame>  $query
     * @return Builder<PhotoFrame>
     */
    public function scopeSelectable(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->whereNotNull('google_drive_file_id');
    }

    /**
     * Preview image URL: the local copy when present, otherwise
     * the Google Drive thumbnail.
     */
    public function previewUrl(): string
    {
        if ($this->frame_path && Storage::disk('public')->exists($this->frame_path)) {
            return Storage::url($this->frame_path);
        }

        return 'https://drive.google.com/thumbnail?id='.$this->google_drive_file_id.'&sz=w1000';
    }
}
