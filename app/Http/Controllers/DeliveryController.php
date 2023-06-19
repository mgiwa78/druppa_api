<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeliveryRequest;
use App\Http\Requests\UpdateDeliveryRequest;
use App\Models\Customer;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeliveryController extends Controller
{


    public function getCustomerDelivery($id)
    {
        $deliveries = Delivery::where('customer_id', '=', $id)
            ->get();

        return response()->json([
            'data' => $deliveries,
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

        return response()->json([
            "data" => $delivery
        ], 201);
    }

    public function show($id)
    {
        $deliveries = Delivery::find($id);
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
}