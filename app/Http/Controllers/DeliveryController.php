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
        $deliveries = Delivery::paginate(10);
        return response()->json(['success' => "success", 'data' => $deliveries], 200);

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