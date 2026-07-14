<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\CityStatus;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Auth;

class UpdateCityRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                'max:100',
                Rule::unique('cities', 'name')
                    ->ignore($this->route('city')->id),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                new Enum(CityStatus::class),
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
            'name.required' => 'City name is required.',
            'name.string' => 'City name must be a valid text.',
            'name.max' => 'City name may not be greater than 100 characters.',
            'name.unique' => 'City name already exists.',

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
            'name' => 'city name',
            'description' => 'description',
            'status' => 'status',
        ];
    }
}
