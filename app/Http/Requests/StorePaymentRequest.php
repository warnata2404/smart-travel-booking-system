<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized.
     */
    public function authorize(): bool
    {
        return Auth::check()
            && Auth::user()->role === UserRole::CUSTOMER;
    }

    /**
     * Validation rules.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'booking_id' => [
                'required',
                'integer',
                'exists:bookings,id',
            ],

            'voucher_id' => [
                'nullable',
                'integer',
                'exists:vouchers,id',
            ],

            'payment_proof' => [
                'required',
                'file',
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120',
            ],
        ];
    }

    /**
     * Validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'booking_id.required' => 'Booking is required.',
            'booking_id.integer' => 'Booking must be a valid selection.',
            'booking_id.exists' => 'Selected booking is invalid.',

            'voucher_id.integer' => 'Voucher must be a valid selection.',
            'voucher_id.exists' => 'Selected voucher is invalid.',

            'payment_proof.required' => 'Payment proof is required.',
            'payment_proof.file' => 'Payment proof must be a valid file.',
            'payment_proof.image' => 'Payment proof must be an image.',
            'payment_proof.mimes' => 'Payment proof must be a JPG, JPEG, or PNG image.',
            'payment_proof.max' => 'Payment proof may not be greater than 5 MB.',
        ];
    }

    /**
     * Custom attribute names.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'booking_id' => 'booking',
            'voucher_id' => 'voucher',
            'payment_proof' => 'payment proof',
        ];
    }
}
