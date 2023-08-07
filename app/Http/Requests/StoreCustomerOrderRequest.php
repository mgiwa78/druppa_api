<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerOrderRequest extends FormRequest
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
            'customer_id' => ['required'],
            'payment_id' => ['required'],
            'package_type' => ['required'],
            'payment_type' => ['required'],
            'shipment_description' => ['required'],
            'origin' => ['required'],
            'delivery_instructions' => ['required'],
            'pickup_address' => ['required'],
            'location_type' => ['required'],
            'pickup_state' => ['required_if:location_type,Inter-State'],
            'dropoff_state' => ['required_if:location_type,Inter-State'],
            'dropoff_address' => ['required'],
        ];
    }
}