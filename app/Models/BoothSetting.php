<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Booth options managed on the RupaVue admin site (Photo Frames page).
 *
 * @property int $id
 * @property bool $guests_can_pick_frame
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class BoothSetting extends Model
{
    protected $table = 'booth_settings';

    protected $casts = [
        'guests_can_pick_frame' => 'boolean',
    ];

    /**
     * Whether guests choose their own frame. When the admin site has
     * not saved the setting (or its table is missing), keep letting
     * guests choose, as the booth did before the setting existed.
     */
    public static function guestsCanPickFrame(): bool
    {
        try {
            $setting = static::query()->first();
        } catch (\Throwable) {
            return true;
        }

        return $setting->guests_can_pick_frame ?? true;
    }
}
