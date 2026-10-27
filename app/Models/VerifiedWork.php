<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerifiedWork extends Model
{
    protected $fillable = [
        'provider_id',
        'client_id',
        'portfolio_item_id',
        'service_id',
        'status',
        'verification_token',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    /**
     * مقدم الخدمة.
     */
    public function provider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    /**
     * العميل.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    /**
     * العمل الموجود في معرض الأعمال.
     */
    public function portfolioItem(): BelongsTo
    {
        return $this->belongsTo(PortfolioItem::class);
    }

    /**
     * الخدمة المرتبطة بالعمل.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}