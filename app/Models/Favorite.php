<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'favorite_user_id',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * المستخدم الذي أضاف المفضلة.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * المستخدم الذي تمت إضافته للمفضلة.
     */
    public function favoriteUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'favorite_user_id');
    }
}