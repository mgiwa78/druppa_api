<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCouponRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\CouponRecords;
use App\Models\Customer;
use Carbon\Carbon;

class CouponController extends Controller
{
    public function store(StoreCouponRequest $request)
    {



        $couponData = $request->except('forUser');
        $coupon = Coupon::create($couponData);

        $coupon->percentage_discount = $request->percentage_discount;

        $couponRecord = new CouponRecords();

        foreach ($request->forUser as $key => $user) {
            $customer = Customer::find($user);
            $wallet = $customer->wallet;

            if ($wallet->balance < $coupon->percentage_discount) {
                return response()->json(['message' => 'Insufficient balance to assign coupon.'], 400);
            }

            $wallet->withdraw($coupon->percentage_discount);
            $couponRecord->customer_id = $user;
            $couponRecord->coupon_id = $coupon->id;
        }

        $couponRecord->save();


        return response()->json(['success' => "success", 'data' => $coupon], 201);
    }

    public function index()
    {
        $coupons = Coupon::paginate();
        return response()->json(['success' => "success", 'data' => $coupons], 200);

    }

    public function show($id)
    {
        $coupon = Coupon::findOrFail($id);

        return response()->json(['success' => "success", 'data' => $coupon, 'message' => 'Coupon retrieved successfully.',], 200);
    }

    public function getCouponCustomers($couponId)
    {
        $customersWithCoupon = Customer::whereHas('couponRecords', function ($query) use ($couponId) {
            $query->where('coupon_id', $couponId);
        })->paginate();
        return response()->json(['success' => "success", 'data' => $customersWithCoupon], 200);

    }
    public function validateCoupon(Request $request)
    {
        $authenticatedUser = Auth::user();
        $request->validate([
            'coupon_code' => 'required|exists:coupons,code',
        ]);

        $coupon = Coupon::where('code', $request->coupon_code)->first();

        if (!$coupon) {
            return response()->json(['message' => 'Coupon not found.'], 404);
        }

        $now = Carbon::now();
        if ($coupon->validFrom > $now || $coupon->validUntil < $now) {
            return response()->json(['message' => 'Coupon is not valid.'], 400);
        }

        if ($coupon->currentUses >= $coupon->maxUses) {
            return response()->json(['message' => 'Coupon has reached its maximum usage.'], 400);
        }

        $confirmIfAllowed = CouponRecords::where([
            'coupon_id' => $coupon->id,
            'customer_id' => $authenticatedUser->id,
        ])->first();

        if (!$confirmIfAllowed) {
            return response()->json(['message' => 'Coupon is not allowed for this customer.'], 403);
        }

        $coupon->increment('currentUses');
        return response()->json(['success' => "success", 'data' => $coupon], 200);

    }

    public function update(Request $request, $id)
    {
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

        return response()->json(['success' => "success", 'data' => $coupon, 'message' => 'Coupon updated successfully.',], 200);
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return response()->json(['success' => "success", 'message' => 'Coupon deleted successfully.',], 200);
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