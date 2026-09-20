<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhotoFrame extends Model
{
    protected $table = 'photo_frames';

    protected $fillable = [
        'frame_name',
        'frame_path',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}