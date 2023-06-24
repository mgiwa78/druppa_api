<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverRequest extends FormRequest
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
            'firstName' => 'sometimes|string',
            'lastName' => 'sometimes|string',
            'gender' => 'sometimes|string',
            'title' => 'sometimes|string',
            'phone_number' => 'sometimes|string',
            'city' => 'sometimes|string',
            'state' => 'sometimes|string',
            'licenseNumber' => 'sometimes|string',
            'licenseExpiration' => 'sometimes|string',
            'vehicleMake' => 'sometimes|string',
            'vehicleModel' => 'sometimes|string',
            'licensePlate' => 'sometimes|string',
            'insurance' => 'sometimes|string',
            'email' => 'sometimes|string',
            'password' => 'sometimes|string|min:6',
        ];
    }
}