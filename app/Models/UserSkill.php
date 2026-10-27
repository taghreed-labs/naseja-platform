<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserSkill extends Model
{
    protected $fillable = [
        'user_id',
        'skill_id',
        'level',
        'years_experience',
    ];

    protected $casts = [
        'years_experience' => 'integer',
    ];

    /**
     * هذه المهارة تابعة لمستخدم.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * المهارة نفسها.
     */
    public function skill(): BelongsTo
    {
        return $this->belongsTo(Skill::class);
    }
}