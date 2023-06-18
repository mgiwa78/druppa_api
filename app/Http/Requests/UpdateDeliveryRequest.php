<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeliveryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'customer_id' => 'integer',
            'tracking_number' => 'string',
            'origin' => 'string',
            'destination' => 'string',
            'pickup_date' => 'string',
            'delivery_date' => 'string',
            'delivery_by' => 'integer|nullable',
        ];
    }
}