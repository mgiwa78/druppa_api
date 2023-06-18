<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InventoryController extends Controller
{


    public function getCustomerInventory($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $deliveries = $customer->deliveries()->get();

        return response()->json([
            'data' => $deliveries,
        ]);
    }
    public function index()
    {
        $deliveries = Inventory::all();
        return response()->json(['success' => "success", 'data' => $deliveries], 200);

    }

    public function store(Request $request)
    {

        $customerID = $request->customer;

        $delivery = new Inventory();



        $delivery->customer_id = $customerID;
        $delivery->product_description = $request->product_description;
        $delivery->quantity = $request->quantity;
        $delivery->warehouse_id = $request->warehouse_id;




        $delivery->save();

        return response()->json([
            'data' => $delivery,
        ], 201);
    }

    public function show($id)
    {
        $deliveries = Inventory::find($id);
        return response()->json(['success' => "success", 'data' => $deliveries], 200);

    }

    public function update(Request $request, $id)
    {
        $delivery = Inventory::find($id);

        $delivery->product_description = $request->product_description;
        $delivery->quantity = $request->quantity;
        $delivery->warehouse_id = $request->warehouse_id;


        $delivery->save();

        return response()->json([
            'data' => $delivery,
        ]);
    }

    public function destroy($id)
    {
        $delivery = Inventory::find($id);
        $delivery->delete();

        return response()->json([
            'message' => 'Inventory record deleted successfully.',
        ]);
    }
}