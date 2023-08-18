<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\InventoryDeliveryRequest;
use App\Http\Requests\StoreInventoryDeliveryRequestRequest;
use App\Http\Requests\UpdateInventoryDeliveryRequestRequest;
use App\Models\CustomerOrder;
use App\Models\Inventory;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class InventoryDeliveryRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authenticatedUser = Auth::user();
        if ($authenticatedUser->type === "Admin") {

            $allInventoryDeliveryRequest = InventoryDeliveryRequest::with("customer")->with("Inventory")->paginate();
            return response()->json(['success' => "success", 'data' => $allInventoryDeliveryRequest], 200);
        }
        if ($authenticatedUser->type === "Customer") {

            $allInventoryDeliveryRequest = InventoryDeliveryRequest::where("customer_id", $authenticatedUser->id)->with("customer")->with("Inventory")->paginate();
            return response()->json(['success' => "success", 'data' => $allInventoryDeliveryRequest], 200);
        }
    }
    public function confirmQuantity($inventory_id)
    {
        $quatity = Inventory::where("inventory_id", $inventory_id);
        return response()->json(['success' => "success", 'data' => $quatity], 200);

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
    public function store(StoreInventoryDeliveryRequestRequest $request)
    {

        $inventoryDeliveryRequest = InventoryDeliveryRequest::create($request->all());
        return response()->json(['success' => "success", 'data' => $inventoryDeliveryRequest], 200);
    }
    public function deliveryRequestApproval(Request $request)
    {

        $inventoryRequestId = $request->inventoryDeliveryRequestID;

        $inventoryDeliveryRequest = InventoryDeliveryRequest::find($inventoryRequestId);

        $inventoryData = Inventory::find($inventoryDeliveryRequest->inventory_id);
        $warehouseData = Warehouse::find($inventoryData->warehouse_id);


        $customerOrder = new CustomerOrder();

        $customerOrder->customer_id = $inventoryDeliveryRequest->customer_id;
        $customerOrder->package_type = "warehousePackage";
        $customerOrder->pickup_address = $warehouseData->location;
        $customerOrder->dropoff_address = $inventoryDeliveryRequest->deliveryAddress;
        $customerOrder->type = "warehouse";
        $customerOrder->warehouse_id = $inventoryData->warehouse_id;
        $customerOrder->save();



        $inventoryDeliveryRequest->status = "Pending Pickup";

        $inventoryDeliveryRequest->save();

        return response()->json(['success' => "success", 'data' => $customerOrder], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(InventoryDeliveryRequest $inventoryDeliveryRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryDeliveryRequest $inventoryDeliveryRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInventoryDeliveryRequestRequest $request, InventoryDeliveryRequest $inventoryDeliveryRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryDeliveryRequest $inventoryDeliveryRequest)
    {
        //
    }
}