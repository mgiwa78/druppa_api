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
    public function showVendorOrders()
    {


        $authenticatedUser = Auth::user();

        if ($authenticatedUser->type === "Vendor") {
            $activityLog = new ActivityLog();

            $activityLog->user()->associate($authenticatedUser);
            $orders = CustomerOrder::where("vendor_id", $authenticatedUser->id)->paginate();

            $activityLog->description = "Access Customer Orders";

            $activityLog->save();
            return response()->json(['success' => 'success', 'data' => $orders], 200);
        }
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
        $customerOrder->location_type = $request->location_type;

        $customerOrder->shipment_description = $request->shipment_description;
        $customerOrder->package_type = $request->package_type;
        $customerOrder->coupon_id = $request->coupon_id;

        $customerOrder->pickup_address = $request->pickup_address;
        $customerOrder->origin = $request->origin;
        $customerOrder->payment_type = $request->payment_type;

        $customerOrder->pickup_state = $request->pickup_state;
        $customerOrder->pickup_address = $request->pickup_address;
        $customerOrder->dropoff_address = $request->dropoff_address;
        $customerOrder->total_payment = $request->total_payment;
        $customerOrder->dropoff_state = $request->dropoff_state;


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
    public function createResturantOrder(StoreCustomerOrderRequest $request)
    {
        $authenticatedUser = Auth::user();

        $request->validated();

        $customerOrder = new CustomerOrder;

        $customerOrder->vendor_id = $request->vendor_id;


        $customerOrder->customer_id = $request->customer_id;
        $customerOrder->order_type = $request->order_type;

        $customerOrder->payment_id = $request->payment_id;
        $customerOrder->location_type = $request->location_type;

        $customerOrder->shipment_description = $request->shipment_description;
        $customerOrder->package_type = $request->package_type;
        $customerOrder->coupon_id = $request->coupon_id;

        $customerOrder->pickup_address = $request->pickup_address;
        $customerOrder->origin = $request->origin;
        $customerOrder->payment_type = $request->payment_type;

        $customerOrder->pickup_state = $request->pickup_state;
        $customerOrder->pickup_address = $request->pickup_address;
        $customerOrder->dropoff_address = $request->dropoff_address;
        $customerOrder->total_payment = $request->total_payment;
        $customerOrder->dropoff_state = $request->dropoff_state;
        $customerOrder->vendor_item_id = $request->vendor_item_id;


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

        // $responseData = $customerOrders->items();
        // $responseData = collect($responseData)->map(function ($customerOrder) {
        //     return [
        //         'id' => $customerOrder->id,
        //         'customer' => $customerOrder->customer,
        //         'customer_id' => $customerOrder->customer_id,
        //         'payment_id' => $customerOrder->payment_id,
        //         'payment_method' => $customerOrder->payment_method,
        //         'shipment_description' => $customerOrder->stashipment_descriptiontus,
        //         'service_rendered' => $customerOrder->service_rendered,
        //         'expected_delivery_date' => $customerOrder->expected_delivery_date,
        //         'distance' => $customerOrder->distance,

        //         'total_payment' => $customerOrder->total_payment,
        //         'shipment_weight' => $customerOrder->shipment_weight,
        //         'dropOff_address' => $customerOrder->dropOff_address,
        //         'dropOff_state' => $customerOrder->dropOff_state,
        //         'dropOff_city' => $customerOrder->dropOff_city,


        //         'status' => $customerOrder->status,
        //         'dropOff_LGA' => $customerOrder->dropOff_LGA,
        //         'pickup_address' => $customerOrder->pickup_address,
        //         'pickup_state' => $customerOrder->pickup_state,
        //         'pickup_lga' => $customerOrder->pickup_lga,
        //         'created_at' => $customerOrder->created_at,
        //     ];
        // });

        // $paginatedResponse = [
        //     'current_page' => $customerOrders->currentPage(),
        //     'per_page' => $customerOrders->perPage(),
        //     'total' => $customerOrders->total(),
        //     'last_page' => $customerOrders->lastPage(),
        //     'data' => $customerOrders,
        // ];

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);


        $activityLog->description = "Access Pending Orders";

        $activityLog->save();

        return response()->json(['success' => "success", 'data' => $customerOrders], 200);
    }
    public function showCustomersOrders($size)
    {
        $authenticatedUser = Auth::user();


        if ($size) {
            $customerOrders = CustomerOrder::where('customer_id', '=', $authenticatedUser->id)->with('customer')->with([
                'delivery' => function ($query) {
                    $query->with('driver');
                }
            ])->orderByDesc('created_at')->paginate($size);

        } else {
            $customerOrders = CustomerOrder::where('customer_id', '=', $authenticatedUser->id)->with('customer')->with("delivery")->orderByDesc('created_at')->paginate();

        }


        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);


        $activityLog->description = "Access Customer Orders Orders";

        $activityLog->save();

        return response()->json(['success' => "success", 'data' => $customerOrders], 200);
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
            return response()->json(['error' => "error", 'message' => "No customer Order found"], 200);
        }
    }
    public function showCustomerOrder($id)
    {
        $customerorder = CustomerOrder::where('customer_id', '=', $id)
            ->get();

        if ($customerorder) {
            return response()->json(['success' => "success", 'data' => $customerorder], 200);
        } else {
            return response()->json(['error' => "error", 'message' => "No customer Order found"], 200);
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