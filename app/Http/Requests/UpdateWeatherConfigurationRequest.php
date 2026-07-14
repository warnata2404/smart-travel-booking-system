<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Enums\WeatherConfigurationStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateWeatherConfigurationRequest extends FormRequest
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
        $weatherConfiguration = $this->route('weather_configuration');

        return [
            'rule_type' => [
                'required',
                'string',
                'max:100',
                Rule::unique(
                    'weather_configurations',
                    'rule_type',
                )->ignore($weatherConfiguration->id),
            ],

            'weather' => [
                'required',
                'string',
                'max:100',
            ],

            'recommendation' => [
                'required',
                'string',
            ],

            'status' => [
                'required',
                Rule::enum(
                    WeatherConfigurationStatus::class,
                ),
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
            'rule_type.required' => 'Rule type is required.',
            'rule_type.string' => 'Rule type must be a valid text.',
            'rule_type.max' => 'Rule type may not be greater than 100 characters.',
            'rule_type.unique' => 'Rule type already exists.',

            'weather.required' => 'Weather is required.',
            'weather.string' => 'Weather must be a valid text.',
            'weather.max' => 'Weather may not be greater than 100 characters.',

            'recommendation.required' => 'Recommendation is required.',
            'recommendation.string' => 'Recommendation must be a valid text.',

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
            'rule_type' => 'rule type',
            'weather' => 'weather',
            'recommendation' => 'recommendation',
            'status' => 'status',
        ];
    }
}
