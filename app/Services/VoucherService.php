<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\UserRole;
use App\Enums\VoucherStatus;
use App\Models\Reward;
use App\Models\Voucher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VoucherService
{
    /**
     * Voucher validity period (days).
     */
    private const VOUCHER_VALID_DAYS = 30;

    /**
     * Get all vouchers.
     *
     * Admin:
     * - View all vouchers.
     *
     * Customer:
     * - View own vouchers only.
     *
     * @return Collection<int, Voucher>
     */
    public function getAll(): Collection
    {
        $query = Voucher::query()
            ->with([
                'reward.customer',
                'reward.trip.booking.destination',
                'reward.rewardConfiguration',
                'payment',
            ])
            ->latest();

        if (Auth::user()?->role === UserRole::CUSTOMER) {
            $query->whereHas('reward', function ($query): void {
                $query->where(
                    'customer_id',
                    Auth::id(),
                );
            });
        }

        return $query->get();
    }

    /**
     * Get voucher by ID.
     */
    public function getById(int $id): Voucher
    {
        $query = Voucher::query()
            ->with([
                'reward.customer',
                'reward.trip.booking.destination',
                'reward.rewardConfiguration',
                'payment',
            ])
            ->whereKey($id);

        if (Auth::user()?->role === UserRole::CUSTOMER) {
            $query->whereHas('reward', function ($query): void {
                $query->where(
                    'customer_id',
                    Auth::id(),
                );
            });
        }

        return $query->firstOrFail();
    }

    /**
     * Generate voucher from reward.
     */
    public function generate(Reward $reward): Voucher
    {
        return DB::transaction(function () use ($reward): Voucher {

            $reward->loadMissing('rewardConfiguration');

            /*
            |--------------------------------------------------------------------------
            | Prevent duplicate voucher
            |--------------------------------------------------------------------------
            */

            $existingVoucher = Voucher::query()
                ->where('reward_id', $reward->id)
                ->first();

            if ($existingVoucher !== null) {
                return $existingVoucher;
            }

            /*
            |--------------------------------------------------------------------------
            | Create voucher
            |--------------------------------------------------------------------------
            */

            return Voucher::query()->create([
                'reward_id' => $reward->id,

                'code' => $this->generateVoucherCode(),

                'discount_percentage' => $reward
                    ->rewardConfiguration
                    ->discount_percentage,

                'expired_at' => now()->addDays(
                    self::VOUCHER_VALID_DAYS,
                ),

                'status' => VoucherStatus::ACTIVE,
            ]);
        });
    }

    /**
     * Generate unique voucher code.
     */
    private function generateVoucherCode(): string
    {
        do {
            $code = sprintf(
                'VCH-%s-%04d',
                now()->format('YmdHis'),
                random_int(1000, 9999),
            );
        } while (
            Voucher::query()
            ->where('code', $code)
            ->exists()
        );

        return $code;
    }
}
