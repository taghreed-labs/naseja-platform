<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserBadge extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'badge_id',
        'awarded_at',
        'created_at',
    ];

    protected $casts = [
        'awarded_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * الشارة تابعة لمستخدم واحد.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}