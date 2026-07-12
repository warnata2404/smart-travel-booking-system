<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleteTripRequest extends FormRequest
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
            'trip_id' => [
                'required',
                'integer',
                'exists:trips,id',
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
            'trip_id.required' => 'Trip is required.',
            'trip_id.integer' => 'Trip is invalid.',
            'trip_id.exists' => 'Trip does not exist.',
        ];
    }
}
