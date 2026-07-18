<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\DestinationCategory;
use App\Enums\DestinationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destination extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'city_id',
        'name',
        'category',
        'description',
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
            'category' => DestinationCategory::class,
            'status' => DestinationStatus::class,
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Destination belongs to a city.
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Travel routes for this destination.
     */
    public function travelRoutes(): HasMany
    {
        return $this->hasMany(TravelRoute::class);
    }

    /**
     * Bookings for this destination.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
