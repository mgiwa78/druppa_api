<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\Inventory;
use Illuminate\Http\Request;
use App\Models\DeliveryRequest;
use App\Http\Requests\InventoryDeliveryRequest;
use App\Http\Requests\StoreDeliveryRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InventoryController extends Controller
{
    
    public function requestDelivery(InventoryDeliveryRequest $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $deliveryRequest = new DeliveryRequest();
        $deliveryRequest->inventory_id = $inventory->id;
        $deliveryRequest->customer_id = $request->customer_id;
        $deliveryRequest->address = $request->destination;
        $deliveryRequest->quantity_requested = $request->quantity_requested;
        $deliveryRequest->save();

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($deliveryRequest);

        $activityLog->description = "Delivery Request Created";

        $activityLog->save();

        return response()->json(['success' => true, 'data' => $deliveryRequest], 201);
    }

    public function getCustomerInventory($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $inventries = $customer->inventries()->get();

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($inventries);


        $activityLog->description = "Driver Profile Updated";

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