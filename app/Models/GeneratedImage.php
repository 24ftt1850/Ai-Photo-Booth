<?php

namespace App\Models;

use Database\Factories\GeneratedImageFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string|null $image_uid
 * @property string|null $public_token
 * @property int $photo_session_id
 * @property int $theme_id
 * @property int|null $chosen_frame_id
 * @property int|null $model_id
 * @property string $final_prompt_used
 * @property string|null $resolution
 * @property string|null $api_image_cost_bnd
 * @property string|null $total_api_cost_bnd
 * @property string|null $generation_status
 * @property string|null $failure_reason
 * @property string|null $generated_photo_path
 * @property string|null $google_drive_file_id
 * @property string|null $google_drive_url
 * @property string $google_drive_status
 * @property int $is_regeneration
 * @property int $regeneration_number
 * @property int|null $parent_generation_id
 * @property string|null $qr_code_path
 * @property string|null $qr_token
 * @property string|null $retention_expires_at
 * @property int $is_deleted
 * @property string|null $applied_frame_path
 * @property string|null $applied_logo_path
 * @property string|null $applied_watermark_path
 * @property string|null $processing_started_at
 * @property string|null $processing_completed_at
 * @property int|null $processing_time_seconds
 * @property int|null $satisfaction_rating
 * @property string|null $feedback_comment
 * @property string|null $feedback_submitted_at
 * @property Carbon|null $created_at
 * @property string|null $print_status
 * @property Carbon|null $print_requested_at
 * @property Carbon|null $printed_at
 */
class GeneratedImage extends Model
{
    /** @use HasFactory<GeneratedImageFactory> */
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
        'public_token',
        'final_prompt_used',
        'resolution',
        'generated_photo_path',
        'applied_frame_path',
        'chosen_frame_id',
        'generation_status',
        'failure_reason',
        'satisfaction_rating',
        'feedback_comment',

        // Google Drive
        'image_uid',
        'google_drive_file_id',
        'google_drive_url',
        'google_drive_status',

        // Admin print queue
        'print_status',
        'print_requested_at',
        'printed_at',

    ];

    protected $casts = [
        'satisfaction_rating' => 'integer',
        'print_requested_at' => 'datetime',
        'printed_at' => 'datetime',
    ];

    /**
     * @return BelongsTo<PhotoSession, $this>
     */
    public function photoSession(): BelongsTo
    {
        return $this->belongsTo(PhotoSession::class);
    }

    /**
     * @return BelongsTo<Theme, $this>
     */
    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }

    /**
     * Link the guest's QR code opens: the shared Google Drive file
     * when it is public, otherwise this app's own photo page.
     */
    public function publicPhotoUrl(): string
    {
        if ($this->google_drive_status === 'public' && $this->google_drive_url) {
            return $this->google_drive_url;
        }

        return route('public.photo.show', $this->public_token);
    }
}
