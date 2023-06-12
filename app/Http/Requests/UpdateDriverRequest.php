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
            'firstName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'title' => 'required',
            'phone_number' => 'required',
            'type' => 'required',
            'city' => 'required',
            'state' => 'required',
            'licenseNumber' => 'required',
            'licenseExpiration' => 'required',
            'vehicleMake' => 'required',
            'vehicleModel' => 'required',
            'licensePlate' => 'required',
            'insurance' => 'required',
            'password' => 'required|min:6',
        ];
    }
}
