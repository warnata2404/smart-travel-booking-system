<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use App\Services\BookingService;
use App\Services\CityService;
use App\Services\TravelAnalysisService;
use App\Services\TravelRouteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
    public function __construct(
        private readonly BookingService $bookingService,
        private readonly TravelAnalysisService $travelAnalysisService,
        private readonly CityService $cityService,
        private readonly TravelRouteService $travelRouteService,
    ) {}

    /**
     * Display booking list.
     */
    public function index(): Response
    {
        return Inertia::render('Bookings/Index', [
            'bookings' => $this->bookingService->getAll(),
        ]);
    }

    /**
     * Display create booking form.
     */
    public function create(): Response
    {
        return Inertia::render('Bookings/Create', [
            'cities' => $this->cityService->getAll(),
            'travelRoutes' => $this->travelRouteService->getAll(),

            /*
            |--------------------------------------------------------------------------
            | Initial State
            |--------------------------------------------------------------------------
            */

            'analysisResult' => null,
            'bookingData' => null,
        ]);
    }

    /**
     * Generate trip analysis before creating a booking.
     */
    public function review(
        Request $request,
    ): Response {
        $validated = $request->validate([
            'origin_city_id' => ['required', 'integer'],
            'destination_id' => ['required', 'integer'],
            'departure_date' => ['required', 'date'],
            'departure_time' => ['required'],
        ]);

        $analysisResult = $this->travelAnalysisService->analyze(
            $validated,
        );

        return Inertia::render('Bookings/Create', [

            /*
            |--------------------------------------------------------------------------
            | Master Data
            |--------------------------------------------------------------------------
            */

            'cities' => $this->cityService->getAll(),

            'travelRoutes' => $this->travelRouteService->getAll(),

            /*
            |--------------------------------------------------------------------------
            | Preserve Form Values
            |--------------------------------------------------------------------------
            */

            'formData' => $validated,

            /*
            |--------------------------------------------------------------------------
            | Trip Analysis
            |--------------------------------------------------------------------------
            */

            'analysisResult' => $analysisResult,

            /*
            |--------------------------------------------------------------------------
            | Booking Payload
            |--------------------------------------------------------------------------
            */

            'bookingData' => [
                'travel_route_id' => $analysisResult['travel_route_id'],
                'departure_date' => $analysisResult['departure_date'],
                'departure_time' => $analysisResult['departure_time'],
            ],
        ]);
    }

    /**
     * Store a new booking after the trip analysis is confirmed.
     */
    public function store(
        StoreBookingRequest $request,
    ): RedirectResponse {
        $this->bookingService->create(
            $request->validated(),
        );

        return redirect()
            ->route('bookings.index')
            ->with(
                'success',
                'Booking created successfully.',
            );
    }

    /**
     * Display booking detail.
     */
    public function show(
        Booking $booking,
    ): Response {
        return Inertia::render('Bookings/Show', [
            'booking' => $this->bookingService->getById(
                $booking->id,
            ),
        ]);
    }
}
