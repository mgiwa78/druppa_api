<?php

namespace App\Http\Controllers;

use App\Models\CustomerOrder;
use App\Http\Requests\StoreCustomerOrderRequest;
use App\Http\Requests\UpdateCustomerOrderRequest;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\Delivery;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $orders = CustomerOrder::all();

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);


        $activityLog->description = "Access Customer Orders";

        $activityLog->save();
        return response()->json(['success' => 'success', 'data' => $orders], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreCustomerOrderRequest $request)
    {
        $authenticatedUser = Auth::user();

        $request->validated();

        $customerOrder = new CustomerOrder;

        $customerOrder->customer_id = $request->customer_id;
        $customerOrder->payment_id = $request->payment_id;

        $customerOrder->shipment_description = $request->shipment_description;
        $customerOrder->service_rendered = $request->service_rendered;

        $customerOrder->pickup_address = $request->pickup_address;
        $customerOrder->payment_method = $request->payment_method;
        $customerOrder->expected_delivery_date = $request->expected_delivery_date;

        $customerOrder->pickup_state = $request->pickup_state;
        $customerOrder->pickup_lga = $request->pickup_lga;
        $customerOrder->pickup_city = $request->pickup_city;

        $customerOrder->dropOff_LGA = $request->dropOff_LGA;
        $customerOrder->dropOff_address = $request->dropOff_address;
        $customerOrder->total_payment = $request->total_payment;

        $customerOrder->dropOff_state = $request->dropOff_state;
        $customerOrder->dropOff_city = $request->dropOff_city;
        $customerOrder->shipment_weight = $request->shipment_weight;



        $customerOrder->save();

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($customerOrder);


        $activityLog->description = "Generated invoice";

        $activityLog->save();

        return response()->json([
            "data" => $customerOrder
        ], 201);
    }


    public function showPendingOrders($size)
    {


        if ($size) {
            $customerOrders = CustomerOrder::where('status', '=', 'Pending')->with('customer')->orderByDesc('created_at')->paginate($size);

        } else {
            $customerOrders = CustomerOrder::where('status', '=', 'Pending')->with('customer')->orderByDesc('created_at')->paginate();

        }

        $responseData = $customerOrders->items();
        $responseData = collect($responseData)->map(function ($customerOrder) {
            return [
                'id' => $customerOrder->id,
                'customer' => $customerOrder->customer,
                'payment_id' => $customerOrder->payment_id,
                'request_title' => $customerOrder->request_title,
                'request_description' => $customerOrder->starequest_descriptiontus,
                'total_amount' => $customerOrder->total_amount,
                'payment_method' => $customerOrder->payment_method,
                'payment_status' => $customerOrder->payment_status,
                'shipment_type' => $customerOrder->shipment_type,
                'status' => $customerOrder->status,
                'drop_off' => $customerOrder->drop_off,
                'pick_up' => $customerOrder->pick_up,
                'created_at' => $customerOrder->created_at,
                'shipment_details' => $customerOrder->shipment_details,
            ];
        });

        $paginatedResponse = [
            'current_page' => $customerOrders->currentPage(),
            'per_page' => $customerOrders->perPage(),
            'total' => $customerOrders->total(),
            'last_page' => $customerOrders->lastPage(),
            'data' => $responseData,
        ];
        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);


        $activityLog->description = "Access Pending Orders";

        $activityLog->save();

        return response()->json(['success' => "success", 'data' => $paginatedResponse], 200);
    }
    /**
     * Store a newly created resource in storage.
     */


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $customerorder = CustomerOrder::find($id);

        if ($customerorder) {
            return response()->json(['success' => "success", 'data' => $customerorder], 200);
        } else {
            return response()->json(['error' => "error", 'message' => "No customerorder found"], 200);
        }
    }
    public function showCustomerOrder($id)
    {
        $customerorder = CustomerOrder::where('customer_id', '=', $id)
            ->get();

        if ($customerorder) {
            return response()->json(['success' => "success", 'data' => $customerorder], 200);
        } else {
            return response()->json(['error' => "error", 'message' => "No customerorder found"], 200);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerOrder $customerOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerOrderRequest $request, CustomerOrder $customerOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerOrder $customerOrder)
    {
        //
    }
}