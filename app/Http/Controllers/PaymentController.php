<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class PaymentController extends Controller
{
    public function __construct(
        private readonly PaymentService $paymentService,
    ) {}

    /**
     * Display payment list.
     */
    public function index(): Response
    {
        return Inertia::render('Payments/Index', [
            'payments' => $this->paymentService->getAll(),
        ]);
    }

    /**
     * Display payment form.
     */
    public function create(): Response
    {
        return Inertia::render('Payments/Create', [
            'bookings' => $this->paymentService->getAvailableBookings(),

            'vouchers' => $this->paymentService->getAvailableVouchers(),
        ]);
    }

    /**
     * Store payment.
     */
    public function store(
        StorePaymentRequest $request,
    ): RedirectResponse {

        $payment = $this->paymentService->create(
            $request->validated(),
        );

        return redirect()
            ->route(
                'payments.show',
                $payment->id,
            )
            ->with(
                'success',
                'Payment completed successfully.',
            );
    }

    /**
     * Display payment detail.
     */
    public function show(
        int $payment,
    ): Response {

        return Inertia::render('Payments/Show', [
            'payment' => $this->paymentService
                ->getById($payment),
        ]);
    }
}
