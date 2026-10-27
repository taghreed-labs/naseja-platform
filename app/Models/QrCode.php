<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QrCode extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'type',
        'target_type',
        'target_id',
        'is_active',
        'expires_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * رمز QR تابع لمستخدم واحد.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * العنصر المستهدف برمز QR.
     */
    public function target(): MorphTo
    {
        return $this->morphTo();
    }
    /**
 * عمليات المسح التي تمت على رمز QR.
 */
public function scans(): HasMany
{
    return $this->hasMany(QrScan::class);
}
}