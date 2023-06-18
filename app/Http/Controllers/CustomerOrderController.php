<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder;
use App\Http\Requests\StoreCustomerOrderRequest;
use App\Http\Requests\UpdateCustomerOrderRequest;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = CustomerOrder::all();
        return response()->json(['success' => 'success', 'data' => $orders], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customerorder = CustomerOrder::find($id);

        if ($customerorder) {
            return response()->json(['success' => "success", 'data' => $customerorder], 200);
        } else {
            return response()->json(['error' => "error", 'message' => "No customerorder found"], 200);
        }
    }
    public function showCustomerOrder($id)
    {
        $customerorder = CustomerOrder::where('customer_id', '=', $id)
            ->get();

        if ($customerorder) {
            return response()->json(['success' => "success", 'data' => $customerorder], 200);
        } else {
            return response()->json(['error' => "error", 'message' => "No customerorder found"], 200);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerOrder $customerOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerOrderRequest $request, CustomerOrder $customerOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerOrder $customerOrder)
    {
        //
    }
}