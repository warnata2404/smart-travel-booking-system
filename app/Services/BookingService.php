<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\UserRole;
use App\Models\Booking;
use App\Models\Destination;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingService
{
    /**
     * Get all bookings.
     *
     * Admin:
     * - View all bookings.
     *
     * Customer:
     * - View own bookings only.
     *
     * @return Collection<int, Booking>
     */
    public function getAll(): Collection
    {
        $query = Booking::query()
            ->with([
                'customer',
                'originCity',
                'destination',
                'payment',
                'trip',
            ])
            ->latest();

        if (Auth::user()?->role === UserRole::CUSTOMER) {
            $query->where(
                'customer_id',
                Auth::id(),
            );
        }

        return $query->get();
    }

    /**
     * Get booking by ID.
     *
     * Admin:
     * - View any booking.
     *
     * Customer:
     * - View own booking only.
     */
    public function getById(int $id): Booking
    {
        $query = Booking::query()
            ->with([
                'customer',
                'originCity',
                'destination',
                'payment',
                'trip',
            ])
            ->whereKey($id);

        if (Auth::user()?->role === UserRole::CUSTOMER) {
            $query->where(
                'customer_id',
                Auth::id(),
            );
        }

        return $query->firstOrFail();
    }

    /**
     * Create a new booking.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): Booking
    {
        return DB::transaction(function () use ($data): Booking {

            $destination = Destination::query()
                ->findOrFail($data['destination_id']);

            return Booking::query()->create([
                'booking_number' => $this->generateBookingNumber(),

                'customer_id' => Auth::id(),

                'origin_city_id' => $data['origin_city_id'],

                'destination_id' => $destination->id,

                'price' => $destination->price,

                'distance' => $destination->distance,

                'estimated_duration' => $destination->estimated_duration,

                'departure_date' => $data['departure_date'],

                'departure_time' => $data['departure_time'],

                'status' => BookingStatus::PENDING_PAYMENT,
            ]);
        });
    }

    /**
     * Generate unique booking number.
     */
    private function generateBookingNumber(): string
    {
        do {
            $bookingNumber = sprintf(
                'BK-%s-%04d',
                now()->format('YmdHis'),
                random_int(1, 9999),
            );
        } while (
            Booking::query()
            ->where('booking_number', $bookingNumber)
            ->exists()
        );

        return $bookingNumber;
    }
}
