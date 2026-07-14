<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BookingController extends Controller
{
    public function __construct(
        private readonly BookingService $bookingService,
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
     * Display booking form.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Bookings/Create', [
            'bookingData' => $request->only([
                'origin_city_id',
                'destination_id',
                'departure_date',
                'departure_time',
                'distance',
                'estimated_duration',
                'price',
            ]),
        ]);
    }

    /**
     * Store booking.
     */
    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $this->bookingService->create(
            $request->validated()
        );

        return redirect()
            ->route('bookings.index')
            ->with(
                'success',
                'Booking created successfully.'
            );
    }

    /**
     * Display booking detail.
     */
    public function show(int $booking): Response
    {
        return Inertia::render('Bookings/Show', [
            'booking' => $this->bookingService->getById($booking),
        ]);
    }
}
