<?php

declare(strict_types=1);

namespace Koverae\KoveraeBilling\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'team_id',
        'uuid',
        'subscription_id',
        'payment_method',
        'currency',
        'amount',
        'fee',
        'status',
        'metadata',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'float',
        'fee' => 'float',
        'metadata' => 'array',
        'processed_at' => 'datetime',
    ];

    /**
     * Boot the model.
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($transaction) {
            $transaction->uuid = (string) Str::uuid();
        });
    }

    /**
     * Get the subscription associated with this transaction.
     */
    public function subscription(): BelongsTo
    {
        return $this->belongsTo(PlanSubscription::class, 'subscription_id');
    }

    /**
     * Mark the transaction as completed.
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'processed_at' => now(),
        ]);
    }

    /**
     * Mark the transaction as failed.
     */
    public function markAsFailed(): void
    {
        $this->update(['status' => 'failed']);
    }

    /**
     * Mark the transaction as refunded.
     */
    public function markAsRefunded(): void
    {
        $this->update(['status' => 'refunded']);
    }
}
