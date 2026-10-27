<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PortfolioItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'title_ar',
        'title_en',
        'description_ar',
        'description_en',
        'work_date',
        'status',
    ];

    protected $casts = [
        'work_date' => 'date',
    ];

    /**
     * العمل تابع لمستخدم واحد.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
 * العمل يحتوي على عدة صور.
 */
public function images(): HasMany
{
    return $this->hasMany(PortfolioImage::class);
}
/**
 * العمل لديه سجلات تحقق.
 */
public function verifiedWorks(): HasMany
{
    return $this->hasMany(VerifiedWork::class);
}
}