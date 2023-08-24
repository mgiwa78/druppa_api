<?php

namespace App\Http\Controllers;

use App\Models\Retainership;
use App\Http\Requests\StoreRetainershipRequest;
use App\Http\Requests\UpdateRetainershipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetainershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $authenticatedUser = Auth::user();
        if ($authenticatedUser->type === "Admin") {


            $retainerships = Retainership::with("customer")->whereHas('customer', function ($query) use ($authenticatedUser) {
                $query->where('location_id', $authenticatedUser->location_id);
            })->paginate();

            return response()->json(['success' => true, 'data' => $retainerships], 200);
        }
        if ($authenticatedUser->type === "Customer") {


            $retainerships = Retainership::where("customer_id", $authenticatedUser->id)->paginate();
            return response()->json(['success' => true, 'data' => $retainerships], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(StoreRetainershipRequest $request)
    {
        $retainership = Retainership::create($request->all());
        return response()->json(['success' => true, 'data' => $retainership], 201);
        if ($retainership) {
            return response()->json(['success' => true, 'data' => $retainership], 201);
        }


    }

    public function confirmExceededOrders($id)
    {
        $retainership = Retainership::findOrFail($id);

        if ($retainership->current_num_of_orders > $retainership->set_num_of_orders) {
            return response()->json(['error' => "error", 'message' => "Retainership has exceeded the number of orders"], 400);
        } else {
            return response()->json(['message' => 'Retainership has not exceeded the number of orders'], 200);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRetainershipRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Retainership $retainership)
    {
        $authenticatedUser = Auth::user();


        $retainerships = Retainership::where("customer_id", $authenticatedUser->id)->where("set_num_of_orders", "<", "current_num_of_orders")->first();
        return response()->json(['success' => true, 'data' => $retainerships], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Retainership $retainership)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRetainershipRequest $request, Retainership $retainership)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Retainership $retainership)
    {
        //
    }
}