<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMeta extends Model
{
    protected $fillable = [
        'metable_type',
        'metable_id',
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'keywords',
        'canonical_url',
        'og_image',
    ];

    /**
     * العنصر المرتبط ببيانات SEO.
     */
    public function metable(): MorphTo
    {
        return $this->morphTo();
    }
}