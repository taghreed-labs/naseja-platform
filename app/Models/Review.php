<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reviewer_id',
        'service_id',
        'rating',
        'comment',
        'review_date',
    ];

    protected $casts = [
        'rating' => 'integer',
        'review_date' => 'date',
    ];

    /**
     * التقييم كتبه مستخدم واحد.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    /**
     * التقييم تابع لخدمة واحدة.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}