<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
