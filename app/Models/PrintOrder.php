<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * A print job shown on the RupaVue admin site's Print Orders page.
 *
 * The live print_orders table fills the unit prices itself (the
 * trg_print_orders_snapshot trigger), so only the order is inserted.
 */
class PrintOrder extends Model
{
    protected $table = 'print_orders';

    /*
     * print_orders has a created_at column but no updated_at.
     */
    const UPDATED_AT = null;

    protected $fillable = [
        'photo_session_id',
        'generated_image_id',
        'print_config_id',
        'ai_model_id',
        'quantity',
        'print_status',
    ];

    public function generatedImage()
    {
        return $this->belongsTo(GeneratedImage::class);
    }
}
