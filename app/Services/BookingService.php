<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\BookingStatus;
use App\Models\Booking;

class BookingService
{
    /**
     * Create a new booking.
     *
     * @param array<string, mixed> $data
     */
    public function create(array $data): Booking
    {
        $data['status'] = BookingStatus::PENDING_PAYMENT;

        return Booking::create($data);
    }
}
