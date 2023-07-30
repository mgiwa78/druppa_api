<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Customer;

class CouponController extends Controller
{
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'code' => 'required|unique:coupons',
            'discount' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'max_uses' => 'required|integer|min:1',
            'user_id' => 'required|integer|min:1',
        ]);

        // // Create the coupon
        // $coupon = Coupon::create($request->all());

        // Create the coupon and associate it with the admin user
        $coupon = Coupon::create(array_merge($request->all(), [
            'user_id' => Auth::id(), // Assuming you are using Laravel's built-in authentication
        ]));

        return response()->json($coupon, 201);
    }

    public function index()
    {
        $coupons = Coupon::all();

        return response()->json($coupons);
    }

    public function show($id)
    {
        $coupon = Coupon::findOrFail($id);

        return response()->json($coupon);
    }

    public function update(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'code' => 'required|unique:coupons,code,' . $id,
            'discount' => 'required|numeric|min:0',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after:valid_from',
            'max_uses' => 'required|integer|min:1',
        ]);

        // Update the coupon
        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->all());

        return response()->json($coupon);
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return response()->json(null, 204);
    }


    public function assignToCustomer($couponId, $customerId)
    {
        $coupon = Coupon::find($couponId);
        $customer = Customer::find($customerId);

        // Check if the coupon and customer exist
        if (!$coupon || !$customer) {
            return response()->json(['message' => 'Coupon or Customer not found.'], 404);
        }

        // Check if the coupon is already assigned to the customer
        if ($coupon->customers()->where('customer_id', $customer->id)->exists()) {
            return response()->json(['message' => 'Coupon already assigned to this customer.'], 400);
        }

        // Assign the coupon to the customer
        $coupon->customers()->attach($customer);

        return response()->json(['message' => 'Coupon successfully assigned to the customer.'], 200);
    }
}
