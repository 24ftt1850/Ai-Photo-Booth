<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ThemeCategory extends Model
{
    protected $table = 'theme_categories';

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /**
     * Themes assigned to this category.
     *
     * @return BelongsToMany<Theme, $this>
     */
    public function themes(): BelongsToMany
    {
        return $this->belongsToMany(
            Theme::class,
            'photoshoot_theme_category',
            'category_id',
            'theme_id'
        );
    }
}