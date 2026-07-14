<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\RewardConfigurationStatus;
use App\Enums\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateRewardConfigurationRequest extends FormRequest
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
        $rewardConfiguration = $this->route('reward_configuration');

        return [
            'minimum_distance' => [
                'required',
                'integer',
                'min:1',
                Rule::unique(
                    'reward_configurations',
                    'minimum_distance',
                )->ignore($rewardConfiguration->id),
            ],

            'reward_name' => [
                'required',
                'string',
                'max:100',
                Rule::unique(
                    'reward_configurations',
                    'reward_name',
                )->ignore($rewardConfiguration->id),
            ],

            'discount_percentage' => [
                'required',
                'numeric',
                'min:0',
                'max:100',
            ],

            'status' => [
                'required',
                Rule::enum(
                    RewardConfigurationStatus::class,
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
            'minimum_distance.required' => 'Minimum distance is required.',
            'minimum_distance.integer' => 'Minimum distance must be an integer.',
            'minimum_distance.min' => 'Minimum distance must be at least 1 km.',
            'minimum_distance.unique' => 'Minimum distance already exists.',

            'reward_name.required' => 'Reward name is required.',
            'reward_name.string' => 'Reward name must be a valid text.',
            'reward_name.max' => 'Reward name may not be greater than 100 characters.',
            'reward_name.unique' => 'Reward name already exists.',

            'discount_percentage.required' => 'Discount percentage is required.',
            'discount_percentage.numeric' => 'Discount percentage must be a valid number.',
            'discount_percentage.min' => 'Discount percentage must be greater than or equal to 0.',
            'discount_percentage.max' => 'Discount percentage may not be greater than 100.',

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
            'minimum_distance' => 'minimum distance',
            'reward_name' => 'reward name',
            'discount_percentage' => 'discount percentage',
            'status' => 'status',
        ];
    }
}
