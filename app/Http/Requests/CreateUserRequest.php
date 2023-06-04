<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function prepareForValidation()
    {
        $this->merge(['postal_code' => $this->postalCode]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|arrsay|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required'],
            'phone_number' => ['sometimes', 'required'],
            'title' => ['sometimes', 'required'],
            'gender' => ['sometimes', 'required'],
            'type' => ['sometimes', 'required', Rule::in(['Customer', 'Admin', 'Driver'])],
            'email' => ['sometimes', 'required', 'email'],
            'address' => ['required'],
            'city' => ['required'],
            'state' => ['required'],
            'postalCode' => ['required']
        ];
    }
}