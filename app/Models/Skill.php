<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skill extends Model
{
    protected $fillable = [
        'category_id',
        'name_ar',
        'name_en',
        'slug',
        'description',
        'status',
    ];

    /**
     * المهارة تتبع تصنيفًا واحدًا.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * المستخدمون الذين يمتلكون هذه المهارة.
     */
    public function userSkills(): HasMany
    {
        return $this->hasMany(UserSkill::class);
    }
}