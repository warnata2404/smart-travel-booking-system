<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;
use App\Enums\TripStatus;
use App\Enums\VoucherStatus;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Reward;
use App\Models\Trip;
use App\Models\Voucher;

class DashboardService
{
    /**
     * Dashboard summary.
     *
     * @return array<string,mixed>
     */
    public function summary(): array
    {
        return [

            /*
            |--------------------------------------------------------------------------
            | Totals
            |--------------------------------------------------------------------------
            */

            'totalBookings' => Booking::query()->count(),

            'totalPayments' => Payment::query()->count(),

            'totalTrips' => Trip::query()->count(),

            'totalRewards' => Reward::query()->count(),

            'totalVouchers' => Voucher::query()->count(),

            /*
            |--------------------------------------------------------------------------
            | Booking
            |--------------------------------------------------------------------------
            */

            'pendingBookings' => Booking::query()
                ->where(
                    'status',
                    BookingStatus::PENDING_PAYMENT
                )
                ->count(),

            'confirmedBookings' => Booking::query()
                ->where(
                    'status',
                    BookingStatus::CONFIRMED
                )
                ->count(),

            'completedBookings' => Booking::query()
                ->where(
                    'status',
                    BookingStatus::COMPLETED
                )
                ->count(),

            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */

            'paidPayments' => Payment::query()
                ->where(
                    'status',
                    PaymentStatus::PAID
                )
                ->count(),

            /*
            |--------------------------------------------------------------------------
            | Trip
            |--------------------------------------------------------------------------
            */

            'notStartedTrips' => Trip::query()
                ->where(
                    'status',
                    TripStatus::NOT_STARTED
                )
                ->count(),

            'onGoingTrips' => Trip::query()
                ->where(
                    'status',
                    TripStatus::ON_GOING
                )
                ->count(),

            'completedTrips' => Trip::query()
                ->where(
                    'status',
                    TripStatus::COMPLETED
                )
                ->count(),

            /*
            |--------------------------------------------------------------------------
            | Voucher
            |--------------------------------------------------------------------------
            */

            'activeVouchers' => Voucher::query()
                ->where(
                    'status',
                    VoucherStatus::ACTIVE
                )
                ->count(),

            'usedVouchers' => Voucher::query()
                ->where(
                    'status',
                    VoucherStatus::USED
                )
                ->count(),

            'expiredVouchers' => Voucher::query()
                ->where(
                    'status',
                    VoucherStatus::EXPIRED
                )
                ->count(),
        ];
    }
}
