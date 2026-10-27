<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'price',
        'price_type',
        'duration',
        'status',
    ];

    /**
     * صاحب الخدمة
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * تصنيف الخدمة
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}