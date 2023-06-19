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
        $inventries = $customer->inventries()->get();

        return response()->json([
            'data' => $inventries,
        ]);
    }
    public function index()
    {
        $inventries = Inventory::all();
        return response()->json(['success' => "success", 'data' => $inventries], 200);

    }

    public function store(Request $request)
    {

        $customerID = $request->customer;

        $inventries = new Inventory();



        $inventries->customer_id = $customerID;
        $inventries->product_description = $request->product_description;
        $inventries->quantity = $request->quantity;
        $inventries->warehouse_id = $request->warehouse_id;




        $inventries->save();

        return response()->json([
            'data' => $inventries,
        ], 201);
    }

    public function show($id)
    {
        $inventries = Inventory::find($id);
        return response()->json(['success' => "success", 'data' => $inventries], 200);

    }

    public function update(Request $request, $id)
    {
        $inventries = Inventory::find($id);

        $inventries->product_description = $request->product_description;
        $inventries->quantity = $request->quantity;
        $inventries->warehouse_id = $request->warehouse_id;


        $inventries->save();

        return response()->json([
            'data' => $inventries,
        ]);
    }

    public function destroy($id)
    {
        $inventries = Inventory::find($id);
        $inventries->delete();

        return response()->json([
            'message' => 'Inventory record deleted successfully.',
        ]);
    }
}