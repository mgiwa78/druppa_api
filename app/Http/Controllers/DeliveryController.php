<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\CustomerOrder;
use App\Models\Delivery;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeliveryController extends Controller
{


    public function getCustomerDelivery($id)
    {

        $deliveries = Delivery::where('customer_id', '=', $id)->with('driver')->paginate();


        $responseData = $deliveries->items();
        $responseData = collect($responseData)->map(function ($delivery) {
            return [
                'id' => $delivery->id,
                'customer_id' => $delivery->customer_id,
                'customer_order_id' => $delivery->customer_order_id,
                'tracking_number' => $delivery->tracking_number,
                'status' => $delivery->status,
                'state' => $delivery->state,
                'city' => $delivery->city,
                'origin' => $delivery->origin,
                'destination' => $delivery->destination,
                'pickup_date' => $delivery->pickup_date,
                'delivery_date' => $delivery->delivery_date,
                'driver' => $delivery->driver
            ];
        });

        $paginatedResponse = [
            'current_page' => $deliveries->currentPage(),
            'per_page' => $deliveries->perPage(),
            'total' => $deliveries->total(),
            'last_page' => $deliveries->lastPage(),
            'data' => $responseData,
        ];

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);


        $activityLog->description = "Access Customer Deliveries";

        $activityLog->save();

        return response()->json([
            'data' => $paginatedResponse,
        ]);
    }
    public function index()
    {
        $deliveries = Delivery::with('driver')->with("customer")->paginate();

        $responseData = $deliveries->items();
        $responseData = collect($responseData)->map(function ($delivery) {
            return [
                'id' => $delivery->id,
                'customer' => $delivery->customer,
                'customer_order_id' => $delivery->customer_order_id,
                'tracking_number' => $delivery->tracking_number,
                'status' => $delivery->status,
                'state' => $delivery->state,
                'city' => $delivery->city,
                'origin' => $delivery->origin,
                'destination' => $delivery->destination,
                'pickup_date' => $delivery->pickup_date,
                'delivery_date' => $delivery->delivery_date,
                'driver' => $delivery->driver
            ];
        });

        $paginatedResponse = [
            'current_page' => $deliveries->currentPage(),
            'per_page' => $deliveries->perPage(),
            'total' => $deliveries->total(),
            'last_page' => $deliveries->lastPage(),
            'data' => $responseData,
        ];

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);


        $activityLog->description = "Access All Deliveries";

        $activityLog->save();
        return response()->json(['success' => true, 'data' => $paginatedResponse], 200);
    }

    public function store(StoreDeliveryRequest $request)
    {
        $request->validated();

        $delivery = new Delivery;

        $delivery->origin = $request->origin;
        $delivery->city = $request->city;
        $delivery->destination = $request->destination;
        $delivery->pickup_date = $request->pickup_date;
        $delivery->customer_id = $request->customer_id;
        $delivery->tracking_number = $request->tracking_number;
        $delivery->state = $request->state;

        $delivery->delivery_date = $request->delivery_date;
        $delivery->driver_id = $request->driver_id;


        $delivery->save();

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($delivery);


        $activityLog->description = "Created New Delivery";

        $activityLog->save();

        return response()->json([
            "data" => $delivery
        ], 201);
    }

    public function show($id)
    {
        $deliveries = Delivery::find($id);

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($deliveries);


        $activityLog->description = "Access Delivery";

        $activityLog->save();

        return response()->json(['success' => "success", 'data' => $deliveries], 200);
    }

    public function showPending()
    {
        $deliveries = Delivery::where('status', '=', 'Pending')->get();
        return response()->json(['success' => "success", 'data' => $deliveries], 200);
    }

    public function update(UpdateDeliveryRequest $request, $id)
    {


        $request->validated();

        $delivery = Delivery::find($id);
        $delivery->origin = $request->origin;
        $delivery->destination = $request->destination;

        $delivery->delivery_date = $request->delivery_date;
        $delivery->driver_id = $request->driver_id;

        $delivery->save();

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($delivery);


        $activityLog->description = "Updated Delivery";

        $activityLog->save();
        return response()->json([
            'data' => $delivery,
        ]);
    }

    public function destroy($id)
    {
        $delivery = Delivery::find($id);
        $delivery->delete();

        return response()->json([
            'message' => 'Delivery record deleted successfully.',
        ]);
    }

    public function getDeliveryCount()
    {
        $count = Delivery::count();
        return response()->json(['count' => $count], 200);
    }
    public function getDriverDeliveries()
    {
        $authenticatedUser = Auth::user();
        if ($authenticatedUser->type === "Driver") {

            $deliveries = Delivery::where('driver_id', '=', $authenticatedUser->id)->with('driver')->with('customer')->paginate();

            return response()->json(['message' => 'success', 'data' => $deliveries], 200);
        } else {
            return response()->json(['error' => 'error', 'message' => 'No driver found'], 404);

        }



    }
    public function getDriverOngoingDeliveries()
    {
        $authenticatedUser = Auth::user();
        if ($authenticatedUser->type === "Driver") {

            $deliveries = Delivery::where('driver_id', '=', $authenticatedUser->id)->where("status", "!=", "Delivered")->with('driver')->with('customer')->paginate();

            return response()->json(['message' => 'success', 'data' => $deliveries], 200);
        } else {
            return response()->json(['error' => 'error', 'message' => 'No driver found'], 404);

        }



    }
    public function assignOrderToDriver($id)
    {
        $authenticatedUser = Auth::user();

        if ($authenticatedUser->type === "Driver") {

            $check = Delivery::where("driver_id", "=", "$authenticatedUser->id")->where("status", "!=", "Delivered")->exists();
            if ($check) {
                return response()->json(['error' => 'error', 'message' => 'You Have Incomplete Deliveries'], 401);

            }

            $customer_order = CustomerOrder::find($id);

            $check22 = Delivery::where("customer_order_id", "=", "$id")->exists();
            if ($check22) {
                return response()->json(['error' => 'error', 'message' => 'Delivery Is Already active'], 401);
            }

            $customer_order->status = "Pending Pickup";
            $customer_order->save();


            $newDelivery = new Delivery();


            $newDelivery->customer_id = $customer_order->customer_id;
            $newDelivery->customer_order_id = $customer_order->id;
            $newDelivery->status = "Pending Pickup";
            $newDelivery->driver_id = $authenticatedUser->id;
            $newDelivery->tracking_number = Str::uuid()->toString();

            $newDelivery->save();

            return response()->json(['success' => "success", 'data' => $newDelivery], 200);
        }


    }
}