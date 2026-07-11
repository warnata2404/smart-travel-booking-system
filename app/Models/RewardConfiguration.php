<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\RewardConfigurationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RewardConfiguration extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'minimum_distance',
        'reward_name',
        'discount_percentage',
        'status',
    ];

    /**
     * Attribute casting.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'minimum_distance' => 'integer',
            'discount_percentage' => 'decimal:2',
            'status' => RewardConfigurationStatus::class,
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Rewards generated using this configuration.
     */
    public function rewards(): HasMany
    {
        return $this->hasMany(Reward::class);
    }
}
