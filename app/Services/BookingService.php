<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\TravelRouteStatus;
use App\Enums\UserRole;
use App\Models\Booking;
use App\Models\TravelRoute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingService
{
    /**
     * Get all bookings.
     *
     * @return Collection<int, Booking>
     */
    public function getAll(): Collection
    {
        $query = Booking::query()
            ->with([
                'customer',
                'travelRoute',
                'travelRoute.originCity',
                'travelRoute.destination',
                'travelRoute.destination.city',
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
     */
    public function getById(int $id): Booking
    {
        $query = Booking::query()
            ->with([
                'customer',
                'travelRoute',
                'travelRoute.originCity',
                'travelRoute.destination',
                'travelRoute.destination.city',
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

            $travelRoute = TravelRoute::query()
                ->with([
                    'originCity',
                    'destination',
                    'destination.city',
                ])
                ->where(
                    'status',
                    TravelRouteStatus::ACTIVE,
                )
                ->findOrFail(
                    $data['travel_route_id'],
                );

            $booking = Booking::query()->create([

                'booking_number' => $this->generateBookingNumber(),

                'customer_id' => Auth::id(),

                'travel_route_id' => $travelRoute->id,

                /*
                |--------------------------------------------------------------------------
                | Booking Snapshot
                |--------------------------------------------------------------------------
                |
                | Snapshot values are copied from the selected Travel Route so
                | historical booking data remains unchanged even if the Travel
                | Route is updated in the future.
                |
                */

                'origin_city_id' => $travelRoute->origin_city_id,

                'destination_id' => $travelRoute->destination_id,

                'price' => $travelRoute->base_price,

                'distance' => $travelRoute->distance,

                'estimated_duration' => $travelRoute->estimated_duration,

                'departure_date' => $data['departure_date'],

                'departure_time' => $data['departure_time'],

                'status' => BookingStatus::PENDING_PAYMENT,
            ]);

            return $booking->load([
                'customer',
                'travelRoute',
                'travelRoute.originCity',
                'travelRoute.destination',
                'travelRoute.destination.city',
                'originCity',
                'destination',
                'payment',
                'trip',
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
            ->where(
                'booking_number',
                $bookingNumber,
            )
            ->exists()
        );

        return $bookingNumber;
    }
}
