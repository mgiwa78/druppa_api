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
            'service_rendered' => ['required'],
            'payment_method' => ['required'],
            'expected_delivery_date' => ['required'],
            'shipment_description' => ['required'],
            'pickup_address' => ['required'],
            'pickup_state' => ['required'],
            'pickup_lga' => ['required'],
            'pickup_city' => ['required'],
            'dropOff_LGA' => ['required'],
            'dropOff_city' => ['required'],
            'dropOff_state' => ['required'],
            'dropOff_address' => ['required'],
            'shipment_weight' => ['required'],
        ];
    }
}