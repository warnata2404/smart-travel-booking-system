<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\DestinationCategory;
use App\Enums\DestinationStatus;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateDestinationRequest extends FormRequest
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
        $destination = $this->route('destination');

        return [
            'city_id' => [
                'required',
                'integer',
                'exists:cities,id',
            ],

            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('destinations', 'name')
                    ->ignore($destination->id)
                    ->where(fn($query) => $query->where(
                        'city_id',
                        $this->input('city_id'),
                    )),
            ],

            'category' => [
                'required',
                Rule::enum(DestinationCategory::class),
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'distance' => [
                'required',
                'numeric',
                'min:0',
            ],

            'estimated_duration' => [
                'required',
                'integer',
                'min:1',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                Rule::enum(DestinationStatus::class),
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
            'city_id.required' => 'City is required.',
            'city_id.integer' => 'City must be a valid selection.',
            'city_id.exists' => 'Selected city is invalid.',

            'name.required' => 'Destination name is required.',
            'name.string' => 'Destination name must be a valid text.',
            'name.max' => 'Destination name may not be greater than 100 characters.',
            'name.unique' => 'Destination name already exists in the selected city.',

            'category.required' => 'Category is required.',
            'category.enum' => 'Selected category is invalid.',

            'price.required' => 'Price is required.',
            'price.numeric' => 'Price must be a valid number.',
            'price.min' => 'Price must be greater than or equal to 0.',

            'distance.required' => 'Distance is required.',
            'distance.numeric' => 'Distance must be a valid number.',
            'distance.min' => 'Distance must be greater than or equal to 0.',

            'estimated_duration.required' => 'Estimated duration is required.',
            'estimated_duration.integer' => 'Estimated duration must be an integer.',
            'estimated_duration.min' => 'Estimated duration must be at least 1 minute.',

            'description.string' => 'Description must be a valid text.',

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
            'city_id' => 'city',
            'name' => 'destination name',
            'category' => 'category',
            'price' => 'price',
            'distance' => 'distance',
            'estimated_duration' => 'estimated duration',
            'description' => 'description',
            'status' => 'status',
        ];
    }
}
