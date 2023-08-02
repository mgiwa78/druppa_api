<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required|unique:coupons,code,' . ($this->coupon ? $this->coupon->id : null),
            'validFrom' => 'required|date',
            'validUntil' => 'required|date|after:valid_from',
            'couponType' => 'in:percentageDiscount,reductionDiscount',
            'status' => 'boolean',
            'reductionAmount' => 'numeric|min:0',
            'percentageDiscount' => 'integer|min:0|max:100',
            'maxUses' => 'required|integer|min:0',
            'currentUses' => 'integer|min:0|max:' . ($this->max_uses ?? PHP_INT_MAX),
        ];
    }

    protected function prepareForValidation()
    {
        $forUserData = json_decode($this->input('forUser'), true);
        if (is_array($forUserData)) {
            $this->merge(['forUser' => $forUserData]);
        } else {
            $this->merge(['forUser' => []]);
        }
    }
}