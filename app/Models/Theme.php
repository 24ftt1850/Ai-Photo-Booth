<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $table = 'photoshoot_themes';

    protected $fillable = [
        'theme_name',
        'description',
        'thumbnail_path',
        'prompt_prefix',
        'prompt_suffix',
        'negative_prompt',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function generatedImages()
    {
        return $this->hasMany(GeneratedImage::class, 'theme_id');
    }
}