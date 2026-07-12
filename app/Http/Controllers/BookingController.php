<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;

class BookingController extends Controller
{
    public function __construct(
        private readonly BookingService $bookingService,
    ) {}

    /**
     * Store a new booking.
     */
    public function store(StoreBookingRequest $request): RedirectResponse
    {
        $this->bookingService->store(
            $request->validated()
        );

        return redirect()
            ->back()
            ->with('success', 'Booking created successfully.');
    }
}
