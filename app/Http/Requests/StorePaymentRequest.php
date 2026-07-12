<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
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
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
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
            'booking_id.exists' => 'Booking is invalid.',

            'voucher_id.exists' => 'Voucher is invalid.',

            'payment_proof.required' => 'Payment proof is required.',
            'payment_proof.image' => 'Payment proof must be an image.',
            'payment_proof.mimes' => 'Payment proof must be a JPG, JPEG, or PNG image.',
            'payment_proof.max' => 'Payment proof may not be greater than 2 MB.',
        ];
    }
}
