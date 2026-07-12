<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentService $paymentService,
    ) {}

    /**
     * Store a payment.
     */
    public function store(StorePaymentRequest $request): RedirectResponse
    {
        $this->paymentService->store(
            $request->validated()
        );

        return redirect()
            ->back()
            ->with('success', 'Payment completed successfully.');
    }
}
