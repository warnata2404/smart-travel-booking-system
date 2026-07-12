<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\TripStatus;
use App\Models\Trip;

class TripService
{
    /**
     * Start a trip.
     */
    public function start(Trip $trip): Trip
    {
        $trip->update([
            'status' => TripStatus::ON_GOING,
            'started_at' => now(),
        ]);

        return $trip->fresh();
    }

    /**
     * Complete a trip.
     */
    public function complete(Trip $trip): Trip
    {
        $trip->update([
            'status' => TripStatus::COMPLETED,
            'completed_at' => now(),
        ]);

        return $trip->fresh();
    }
}
