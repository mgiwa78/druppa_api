<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverRequest extends FormRequest
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
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email|unique:drivers,email',
            'gender' => 'required|string|in:male,female',
            'title' => 'nullable|string',
            'phone_number' => 'required|string',
            'type' => 'required|string|in:Driver,regular',
            'city' => 'required|string',
            'address' => 'required|string',
            'state' => 'required|string',
            'licenseNumber' => 'required|string',
            'licenseExpiration' => 'required|date',
            'vehicleMake' => 'required|string',
            'vehicleModel' => 'required|string',
            'licensePlate' => 'required|string',
            'insurance' => 'string',
            'password' => 'required|min:6',
        ];
    }
}