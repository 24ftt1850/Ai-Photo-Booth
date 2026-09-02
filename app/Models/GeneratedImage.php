<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneratedImage extends Model
{
    use HasFactory;

    /*
     * The live `generated_images` table has a `created_at` column but no
     * `updated_at`, so let Eloquent manage only the former.
     */
    const UPDATED_AT = null;

    protected $fillable = [
        'photo_session_id',
        'theme_id',
        'model_id',
        'final_prompt_used',
        'resolution',
        'generated_photo_path',
        'generation_status',
        'satisfaction_rating',
        'feedback_comment',
    ];

    protected $casts = [
        'satisfaction_rating' => 'integer',
    ];

    public function photoSession()
    {
        return $this->belongsTo(PhotoSession::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }
}
