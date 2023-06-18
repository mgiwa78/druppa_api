<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeliveryController extends Controller
{
    public function fetchDeliveries($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $deliveries = $customer->deliveries()->get();

        return response()->json([
            'data' => $deliveries,
        ]);
    }

    public function index($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $deliveries = $customer->deliveries()->get();

        return response()->json([
            'data' => $deliveries,
        ]);
    }

    public function store(Request $request, $customerId)
    {
        $customer = Customer::findOrFail($customerId);

        $delivery = new Delivery();
        $delivery->customer()->associate($customer);

        // Generate a unique delivery_id using UUID
        $delivery->delivery_id = Str::uuid();

        // Set delivery attributes from the request data
        $delivery->item = $request->input('item');
        $delivery->delivery_id = $request->input('delivery_id');
        $delivery->price = $request->input('price');
        $delivery->address = $request->input('address');
        $delivery->country = $request->input('country');
        $delivery->state = $request->input('state');
        $delivery->status = $request->input('status');

        $delivery->save();

        return response()->json([
            'data' => $delivery,
        ], 201);
    }

    public function show($customerId, $id)
    {
        $customer = Customer::findOrFail($customerId);
        $delivery = $customer->deliveries()->findOrFail($id);

        return response()->json([
            'data' => $delivery,
        ]);
    }

    public function update(Request $request, $customerId, $id)
    {
        $customer = Customer::findOrFail($customerId);
        $delivery = $customer->deliveries()->findOrFail($id);

        // Update delivery attributes from the request data
        $delivery->item = $request->input('item');
        $delivery->delivery_id = $request->input('delivery_id');
        $delivery->price = $request->input('price');
        $delivery->address = $request->input('address');
        $delivery->country = $request->input('country');
        $delivery->state = $request->input('state');
        $delivery->status = $request->input('status');

        $delivery->save();

        return response()->json([
            'data' => $delivery,
        ]);
    }

    public function destroy($customerId, $id)
    {
        $customer = Customer::findOrFail($customerId);
        $delivery = $customer->deliveries()->findOrFail($id);

        $delivery->delete();

        return response()->json([
            'message' => 'Delivery record deleted successfully.',
        ]);
    }
}
