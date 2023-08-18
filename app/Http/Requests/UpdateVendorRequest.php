<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorRequest extends FormRequest
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
            'vendorName' => 'sometimes|string',
            'contactInformation' => 'sometimes|string',
            'password' => 'sometimes|string',
            'email' => 'sometimes|string',
            'address' => 'sometimes|string',
        ];
    }
}