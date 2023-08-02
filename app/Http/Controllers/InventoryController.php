<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InventoryController extends Controller
{


    public function getCustomerInventory($size)
    {
            $authenticatedUser = Auth::user();
        $customer = Customer::findOrFail($authenticatedUser->id);
        
        if ($size) {$inventries = $customer->inventries()->with("customer")->with("warehouse")->paginate($size);}else{
            $inventries = $customer->inventries()->with("customer")->with("warehouse")->paginate();
        }
        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        
        $activityLog->data()->associate($inventries);


        $activityLog->description = "Inventory view";

        $activityLog->save();

        return response()->json([
            'data' => $inventries,
        ]);
    }
    public function index()
    {
        $inventories = Inventory::with('warehouse')->with("customer")->paginate();

        $responseData = $inventories->items();
        $responseData = collect($responseData)->map(function ($inventory) {
            return [
                'id' => $inventory->id,
                'customer' => $inventory->customer,
                'warehouse_id' => $inventory->warehouse_id,
                'product_description' => $inventory->product_description,
                'quantity' => $inventory->quantity,
                'created_at' => $inventory->created_at,
                'updated_at' => $inventory->updated_at,
                'warehouse' => $inventory->warehouse // Include warehouse data
            ];
        });

        $paginatedResponse = [
            'current_page' => $inventories->currentPage(),
            'per_page' => $inventories->perPage(),
            'total' => $inventories->total(),
            'last_page' => $inventories->lastPage(),
            'data' => $responseData,
        ];


        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);


        $activityLog->description = "Access All Inventries";

        $activityLog->save();
        return response()->json(['success' => true, 'data' => $paginatedResponse], 200);
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


        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);


        $activityLog->description = "Created New Inventory";

        $activityLog->save();
        return response()->json([
            'data' => $inventries,
        ], 201);
    }

    public function show($id)
    {
        $inventries = Inventory::find($id);


        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);


        $activityLog->description = "Access Inventory Data";

        $activityLog->save();
        return response()->json(['success' => "success", 'data' => $inventries], 200);
    }

    public function update(Request $request, $id)
    {
        $inventries = Inventory::find($id);

        $inventries->product_description = $request->product_description;
        $inventries->quantity = $request->quantity;
        $inventries->warehouse_id = $request->warehouse_id;


        $inventries->save();



        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($inventries);


        $activityLog->description = "Inventory Updated";

        $activityLog->save();
        return response()->json([
            'data' => $inventries,
        ]);
    }

    public function destroy($id)
    {
        $inventory = Inventory::find($id);
        $inventory->delete();

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($inventory);


        $activityLog->description = "Inventory Deleted";

        $activityLog->save();

        return response()->json([
            'message' => 'Inventory record deleted successfully.',
        ]);
    }

    public function getInventoryCount()
    {
        $count = Inventory::count();
        return response()->json(['count' => $count], 200);
    }
}