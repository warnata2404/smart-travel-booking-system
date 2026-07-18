<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\TravelRouteStatus;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreTravelRouteRequest extends FormRequest
{
    /**
     * Determine whether the user is authorized.
     */
    public function authorize(): bool
    {
        return Auth::check()
            && Auth::user()->role === UserRole::ADMIN;
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
                'different:origin_city_id',
            ],

            'distance' => [
                'required',
                'numeric',
                'gt:0',
            ],

            'estimated_duration' => [
                'required',
                'integer',
                'min:1',
            ],

            'base_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'status' => [
                'required',
                Rule::enum(TravelRouteStatus::class),
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
            'origin_city_id.exists' => 'Selected origin city is invalid.',

            'destination_id.required' => 'Destination is required.',
            'destination_id.integer' => 'Destination must be a valid selection.',
            'destination_id.exists' => 'Selected destination is invalid.',
            'destination_id.different' => 'Origin city and destination must be different.',

            'distance.required' => 'Distance is required.',
            'distance.numeric' => 'Distance must be a valid number.',
            'distance.gt' => 'Distance must be greater than zero.',

            'estimated_duration.required' => 'Estimated duration is required.',
            'estimated_duration.integer' => 'Estimated duration must be an integer.',
            'estimated_duration.min' => 'Estimated duration must be at least 1 minute.',

            'base_price.required' => 'Base price is required.',
            'base_price.numeric' => 'Base price must be a valid number.',
            'base_price.min' => 'Base price cannot be negative.',

            'status.required' => 'Status is required.',
            'status.enum' => 'Selected status is invalid.',
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
            'distance' => 'distance',
            'estimated_duration' => 'estimated duration',
            'base_price' => 'base price',
            'status' => 'status',
        ];
    }
}
