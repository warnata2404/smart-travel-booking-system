<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CompleteTripRequest;
use App\Http\Requests\StartTripRequest;
use App\Services\TripService;
use Illuminate\Http\RedirectResponse;

class TripController extends Controller
{
    public function __construct(
        private readonly TripService $tripService,
    ) {}

    /**
     * Start a trip.
     */
    public function start(StartTripRequest $request): RedirectResponse
    {
        $this->tripService->start(
            $request->validated()
        );

        return redirect()
            ->back()
            ->with('success', 'Trip started successfully.');
    }

    /**
     * Complete a trip.
     */
    public function complete(CompleteTripRequest $request): RedirectResponse
    {
        $this->tripService->complete(
            $request->validated()
        );

        return redirect()
            ->back()
            ->with('success', 'Trip completed successfully.');
    }
}
