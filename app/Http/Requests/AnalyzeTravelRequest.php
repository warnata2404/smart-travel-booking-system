<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;

class AnalyzeTravelRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized.
     */
    public function authorize(): bool
    {
        return $this->user()?->role === UserRole::CUSTOMER;
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
                'min:1',
                'exists:cities,id',
            ],

            'destination_id' => [
                'required',
                'integer',
                'min:1',
                'exists:destinations,id',
            ],

            'departure_date' => [
                'required',
                'date',
                'after_or_equal:today',
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
            'origin_city_id.integer' => 'Origin city must be a valid selection.',
            'origin_city_id.min' => 'Origin city is invalid.',
            'origin_city_id.exists' => 'Selected origin city is invalid.',

            'destination_id.required' => 'Destination is required.',
            'destination_id.integer' => 'Destination must be a valid selection.',
            'destination_id.min' => 'Destination is invalid.',
            'destination_id.exists' => 'Selected destination is invalid.',

            'departure_date.required' => 'Departure date is required.',
            'departure_date.date' => 'Departure date is invalid.',
            'departure_date.after_or_equal' => 'Departure date cannot be earlier than today.',

            'departure_time.required' => 'Departure time is required.',
            'departure_time.date_format' => 'Departure time must use HH:MM format.',
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
            'origin_city_id' => 'origin city',
            'destination_id' => 'destination',
            'departure_date' => 'departure date',
            'departure_time' => 'departure time',
        ];
    }
}
