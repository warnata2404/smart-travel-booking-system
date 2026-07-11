<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reward extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'customer_id',
        'trip_id',
        'reward_configuration_id',
        'total_distance',
        'generated_at',
    ];

    /**
     * Attribute casting.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'total_distance' => 'decimal:2',
            'generated_at' => 'datetime',
        ];
    }

    /**
     * Customer who receives this reward.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Trip that generated this reward.
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    /**
     * Reward configuration used to generate this reward.
     */
    public function rewardConfiguration(): BelongsTo
    {
        return $this->belongsTo(RewardConfiguration::class);
    }

    /**
     * Voucher generated from this reward.
     */
    public function voucher(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Voucher::class);
    }
}
