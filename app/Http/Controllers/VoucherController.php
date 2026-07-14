<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\VoucherService;
use Inertia\Inertia;
use Inertia\Response;

class VoucherController extends Controller
{
    public function __construct(
        private readonly VoucherService $voucherService,
    ) {}

    /**
     * Display voucher list.
     */
    public function index(): Response
    {
        return Inertia::render('Vouchers/Index', [
            'vouchers' => $this->voucherService->getAll(),
        ]);
    }

    /**
     * Display voucher detail.
     */
    public function show(int $voucher): Response
    {
        return Inertia::render('Vouchers/Show', [
            'voucher' => $this->voucherService->getById($voucher),
        ]);
    }
}
