<?php

namespace App\Http\Controllers;

use App\Models\CouponRecords;
use App\Http\Requests\StoreCouponRecordsRequest;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRecordsRequest;

class CouponRecordsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreCouponRecordsRequest $request)
    {
        $request->validated();
        $newCouponRecord = new CouponRecords();

        $newCouponRecord->customer_id = $request->customer_id;
        $newCouponRecord->coupon_id = $request->coupon_id;
        $newCouponRecord->save();

        return response()->json(['success' => true, 'data' => $newCouponRecord], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRecordsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CouponRecords $couponRecords)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CouponRecords $couponRecords)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRecordsRequest $request, CouponRecords $couponRecords)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CouponRecords $couponRecords)
    {
        //
    }
}