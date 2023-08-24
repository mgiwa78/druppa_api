<?php

namespace App\Http\Controllers;

use App\Models\RetainershipInstance;
use App\Http\Requests\StoreRetainershipInstanceRequest;
use App\Http\Requests\UpdateRetainershipInstanceRequest;
use App\Models\Retainership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RetainershipInstanceController extends Controller
{

    public function getInstancesByCustomer($retainership_id)
    {
        $instances = RetainershipInstance::where('retainership_id', $retainership_id)->get();

        return response()->json(['success' => true, 'data' => $instances], 200);

    }
    /**
     * Display a listing of the resource.
     */
    public function getInstancesByRetainership($retainership_id)
    {
        $instances = RetainershipInstance::where('retainership_id', $retainership_id)->with("customer")->get();

        return response()->json($instances);
    }

    public function createInstance(Request $request, $retainership_id)
    {
        $retainership = Retainership::findOrFail($retainership_id);
        $authenticatedUser = Auth::user();
        if ($retainership->current_num_of_orders >= $retainership->set_num_of_orders) {
            return response()->json(['error' => "error", 'message' => "Maximum orders exceeded for this retainership"], 400);

        }


        $instance = new RetainershipInstance();

        $instance->payment_id = $request->payment_id;
        $instance->retainership_id = $request->retainership_id;
        $instance->customer_order_id = $request->customer_order_id;
        $instance->customer_id = $authenticatedUser->id;


        $instance->save();

        $retainership->increment('current_num_of_orders');

        return response()->json(['success' => true, 'data' => $instance], 201);

    }
    public function index()
    {
        //
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
    public function store(StoreRetainershipInstanceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RetainershipInstance $retainershipInstance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RetainershipInstance $retainershipInstance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRetainershipInstanceRequest $request, RetainershipInstance $retainershipInstance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RetainershipInstance $retainershipInstance)
    {
        //
    }
}