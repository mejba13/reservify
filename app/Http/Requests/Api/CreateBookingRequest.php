<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Create Booking Request
 *
 * Validates booking creation data.
 */
class CreateBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'service_id' => ['required', 'exists:services,id'],
            'provider_id' => ['required', 'exists:providers,id'],
            'start_time' => ['required', 'date', 'after:now'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'service_id.required' => 'Please select a service.',
            'service_id.exists' => 'The selected service is not available.',
            'provider_id.required' => 'Please select a provider.',
            'provider_id.exists' => 'The selected provider is not available.',
            'start_time.required' => 'Please select a booking time.',
            'start_time.after' => 'Booking time must be in the future.',
        ];
    }
}
