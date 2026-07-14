<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'booking_number',
        'customer_id',
        'origin_city_id',
        'destination_id',
        'price',
        'distance',
        'estimated_duration',
        'departure_date',
        'departure_time',
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
            'price' => 'decimal:2',
            'distance' => 'decimal:2',
            'estimated_duration' => 'integer',
            'departure_date' => 'date',
            'departure_time' => 'string',
            'status' => BookingStatus::class,
        ];
    }

    /**
     * Customer who owns this booking.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Origin city.
     */
    public function originCity(): BelongsTo
    {
        return $this->belongsTo(City::class, 'origin_city_id');
    }

    /**
     * Destination.
     */
    public function destination(): BelongsTo
    {
        return $this->belongsTo(Destination::class);
    }

    /**
     * Payment.
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Trip.
     */
    public function trip(): HasOne
    {
        return $this->hasOne(Trip::class);
    }
}
