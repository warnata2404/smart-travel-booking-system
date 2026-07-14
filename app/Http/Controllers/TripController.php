<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\TripService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class TripController extends Controller
{
    public function __construct(
        private readonly TripService $tripService,
    ) {}

    /**
     * Display trip list.
     */
    public function index(): Response
    {
        return Inertia::render('Trips/Index', [
            'trips' => $this->tripService->getAll(),
        ]);
    }

    /**
     * Display trip detail.
     */
    public function show(int $trip): Response
    {
        return Inertia::render('Trips/Show', [
            'trip' => $this->tripService->getById($trip),
        ]);
    }

    /**
     * Start trip.
     */
    public function start(int $trip): RedirectResponse
    {
        $tripModel = $this->tripService->getById($trip);

        $this->tripService->start($tripModel);

        return redirect()
            ->route('trips.show', $tripModel->id)
            ->with(
                'success',
                'Trip started successfully.',
            );
    }

    /**
     * Complete trip.
     */
    public function complete(int $trip): RedirectResponse
    {
        $tripModel = $this->tripService->getById($trip);

        $this->tripService->complete($tripModel);

        return redirect()
            ->route('trips.show', $tripModel->id)
            ->with(
                'success',
                'Trip completed successfully.',
            );
    }
}
