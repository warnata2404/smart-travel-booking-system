<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
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

            'travel_route_id' => [
                'required',
                'integer',
                Rule::exists('travel_routes', 'id'),
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

            'travel_route_id.required' => 'Travel route is required.',
            'travel_route_id.integer' => 'Travel route must be a valid selection.',
            'travel_route_id.exists' => 'Selected travel route is invalid.',

            'departure_date.required' => 'Departure date is required.',
            'departure_date.date' => 'Departure date is invalid.',
            'departure_date.after_or_equal' => 'Departure date cannot be earlier than today.',

            'departure_time.required' => 'Departure time is required.',
            'departure_time.date_format' => 'Departure time must use HH:mm format.',

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

            'travel_route_id' => 'travel route',

            'departure_date' => 'departure date',

            'departure_time' => 'departure time',

        ];
    }
}
