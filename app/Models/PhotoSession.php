<?php

namespace App\Models;

use Database\Factories\PhotoSessionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $session_code
 * @property string|null $raw_photo_path
 * @property bool $consent_given
 * @property Carbon|null $consent_timestamp
 * @property int $occasion_id
 * @property string|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class PhotoSession extends Model
{
    /** @use HasFactory<PhotoSessionFactory> */
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

    /**
     * @return HasMany<GeneratedImage, $this>
     */
    public function generatedImages(): HasMany
    {
        return $this->hasMany(GeneratedImage::class);
    }
}
