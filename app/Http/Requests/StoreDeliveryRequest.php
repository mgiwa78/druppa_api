<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDeliveryRequest extends FormRequest
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
            'customer_id' => 'required|integer',
            'tracking_number' => 'required|string',
            'origin' => 'string',
            'destination' => 'required|string',
            'pickup_date' => 'required|string',
            'delivery_date' => 'required|string',
            'delivery_by' => 'integer|nullable',
            'city' => 'required|string',
            'state' => 'required|string',

        ];
    }
}