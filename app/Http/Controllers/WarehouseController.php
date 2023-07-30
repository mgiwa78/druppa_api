<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\Warehouse;
use App\Models\Record;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class WarehouseController extends Controller
{
    public function requestWarehousing(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);

        $record = new Record();
        $record->product_id = null;
        $record->action = 'sent_for_warehousing';
        $record->quantity = $request->input('quantity');
        $record->save();

        // Associate the record with the warehouse
        $warehouse->records()->save($record);

        $authenticatedUser = Auth::user();
        $record->customer_id = $authenticatedUser->id;
        $record->save();

        return response()->json([
            'message' => 'Warehousing request successful.',
            'data' => $record,
        ], 200);
    }

    public function sendProductsForWarehousing(Request $request, $warehouseId)
    {
        $warehouse = Warehouse::findOrFail($warehouseId);

        $record = new Record();
        $record->product_id = $request->input('product_id');
        $record->action = 'sent_for_warehousing';
        $record->quantity = $request->input('quantity');
        $record->save();

        $warehouse->records()->save($record);


        return response()->json([
            'message' => 'Products sent for warehousing.',
            'data' => $record,
        ], 200);
    }

    public function requestDelivery(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $record = new Record();
        $record->product_id = $productId;
        $record->action = 'requested_delivery';
        $record->quantity = $request->input('quantity'); // You can adjust this based on your requirements
        $record->address = $request->input('address'); // Assuming you pass the address in the request
        $record->save();

        // Associate the record with the product
        $product->records()->save($record);

        // You can add any additional logic or validation here as needed.

        return response()->json([
            'message' => 'Delivery request successful.',
            'data' => $record,
        ], 200);
    }

    public function trackRecords($customerId)
    {
        $customer = Customer::findOrFail($customerId);
        $records = $customer->records()->with('product')->get();

        // You can calculate statistics or additional data as needed here.

        return response()->json([
            'data' => $records,
        ], 200);
    }

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

        $warehouse = new Warehouse();



        $warehouse->name = $request->name;
        $warehouse->location = $request->location;
        $warehouse->capacity = $request->capacity;


        $warehouse->save();


        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($warehouse);


        $activityLog->description = "Warehouse Created";

        $activityLog->save();


        return response()->json([
            'data' => $warehouse,
        ], 201);
    }

    public function show($id)
    {
        $warehouse = Warehouse::find($id);
        return response()->json(['success' => "success", 'data' => $warehouse], 200);
    }

    public function update(UpdateWarehouseRequest $request, $id)
    {
        $request->validated();

        $warehouse = Warehouse::find($id);

        $warehouse->name = $request->name;
        $warehouse->location = $request->location;

        $warehouse->capacity = $request->capacity;


        $warehouse->save();


        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($warehouse);


        $activityLog->description = "Warehouse Updated";

        $activityLog->save();
        return response()->json([
            'data' => $warehouse,
        ]);
    }

    public function destroy($id)
    {
        $warehouse = Warehouse::find($id);
        $warehouse->delete();

        return response()->json([
            'message' => 'Warehouse record deleted successfully.',
        ]);
    }
}
