<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'file_path',
        'file_name',
        'mime_type',
        'size',
        'mediable_type',
        'mediable_id',
    ];

    /**
     * الملف تابع لمستخدم واحد.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العنصر المرتبط بهذا الملف.
     */
    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}