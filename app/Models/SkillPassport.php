<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SkillPassport extends Model
{
    protected $fillable = [
        'user_id',
        'skill_id',
        'level',
        'issued_at',
        'expires_at',
        'verification_code',
        'status',
    ];

    protected $casts = [
        'issued_at' => 'date',
        'expires_at' => 'date',
    ];

    /**
     * جواز المهارة تابع لمستخدم واحد.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * جواز المهارة مرتبط بمهارة واحدة.
     */
    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }
}