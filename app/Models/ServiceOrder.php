<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceOrder extends Model
{
    protected $fillable = [
        'service_id',
        'customer_id',
        'provider_id',
        'requirements',
        'preferred_deadline',
        'price_snapshot',
        'price_type_snapshot',
        'duration_snapshot',
        'status',
    ];

    protected $casts = [
        'preferred_deadline' => 'date',
        'price_snapshot' => 'decimal:2',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function provider(): BelongsTo
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}
