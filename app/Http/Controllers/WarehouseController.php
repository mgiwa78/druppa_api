<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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