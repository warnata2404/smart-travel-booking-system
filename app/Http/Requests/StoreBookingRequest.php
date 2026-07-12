<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'origin_city_id' => [
                'required',
                'integer',
                'exists:cities,id',
            ],

            'destination_id' => [
                'required',
                'integer',
                'exists:destinations,id',
            ],

            'departure_date' => [
                'required',
                'date',
            ],

            'departure_time' => [
                'required',
                'date_format:H:i',
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
            'origin_city_id.required' => 'Origin city is required.',
            'origin_city_id.exists' => 'Origin city is invalid.',

            'destination_id.required' => 'Destination is required.',
            'destination_id.exists' => 'Destination is invalid.',

            'departure_date.required' => 'Departure date is required.',
            'departure_date.date' => 'Departure date is invalid.',

            'departure_time.required' => 'Departure time is required.',
            'departure_time.date_format' => 'Departure time must use HH:MM format.',
        ];
    }
}
