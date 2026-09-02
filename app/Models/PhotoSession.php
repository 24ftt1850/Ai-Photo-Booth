<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_code',
        'raw_photo_path',
        'consent_given',
        'consent_timestamp',
        'occasion_id',
        'status',
    ];

    protected $casts = [
        'consent_given' => 'boolean',
        'consent_timestamp' => 'datetime',
    ];

    public function generatedImages()
    {
        return $this->hasMany(GeneratedImage::class);
    }
}
