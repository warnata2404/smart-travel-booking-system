<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\TravelRouteStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelRoute extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'origin_city_id',
        'destination_id',
        'distance',
        'estimated_duration',
        'base_price',
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
            'distance' => 'decimal:2',
            'estimated_duration' => 'integer',
            'base_price' => 'decimal:2',
            'status' => TravelRouteStatus::class,
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Origin city.
     */
    public function originCity(): BelongsTo
    {
        return $this->belongsTo(
            City::class,
            'origin_city_id',
        );
    }

    /**
     * Destination.
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(
            Destination::class,
        );
    }
}
