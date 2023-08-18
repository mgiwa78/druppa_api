<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorItemRequest extends FormRequest
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
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|integer',
            'vendor_id' => 'required|string',
            'vedor_item_category_id' => 'required|string',
        ];
    }
}
