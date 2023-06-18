<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Models\Customer;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WarehouseController extends Controller
{


    public function getCustomerWarehouse($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $deliveries = $customer->deliveries()->get();

        return response()->json([
            'data' => $deliveries,
        ]);
    }
    public function index()
    {
        $deliveries = Warehouse::all();
        return response()->json(['success' => "success", 'data' => $deliveries], 200);

    }

    public function store(StoreWarehouseRequest $request)
    {
        $request->validated();

        $customerID = $request->customer;

        $delivery = new Warehouse();

        // Generate a unique delivery_id using UUID


        // Set delivery attributes from the request data
        $delivery->customer_id = $customerID;
        $delivery->tracking_number = Str::uuid();
        $delivery->origin = $request->origin;
        $delivery->destination = $request->destination;

        $delivery->pickup_date = $request->pickup_date;
        $delivery->delivery_date = $request->delivery_date;
        $delivery->delivery_by = $request->delivery_by;


        $delivery->save();

        return response()->json([
            'data' => $delivery,
        ], 201);
    }

    public function show($id)
    {
        $deliveries = Warehouse::find($id);
        return response()->json(['success' => "success", 'data' => $deliveries], 200);

    }

    public function update(UpdateWarehouseRequest $request, $id)
    {
        $request->validated();

        $delivery = Warehouse::find($id);

        $delivery->origin = $request->origin;
        $delivery->destination = $request->destination;

        $delivery->delivery_date = $request->delivery_date;
        $delivery->delivery_by = $request->delivery_by;


        $delivery->save();

        return response()->json([
            'data' => $delivery,
        ]);
    }

    public function destroy($id)
    {
        $delivery = Warehouse::find($id);
        $delivery->delete();

        return response()->json([
            'message' => 'Warehouse record deleted successfully.',
        ]);
    }
}