<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with("customer")->paginate();

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);


        $activityLog->description = "Access All Invoices";

        $activityLog->save();

        return response()->json(['success' => true, 'data' => $invoices], 200);
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
    public function store(StoreInvoiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $invoices = Invoice::find($id);

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($invoices);


        $activityLog->description = "Access Delivery";

        $activityLog->save();

        return response()->json(['success' => "success", 'data' => $invoices], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */public function destroy($id)
    {
        $invoice = Invoice::find($id);
        $invoice->delete();

        return response()->json([
            'message' => 'Invoice record deleted successfully.',
        ]);
    }

    public function getInvoiceCount()
    {
        $count = Invoice::count();
        return response()->json(['count' => $count], 200);
    }
    public function getCustomerInvoices($size)
    {
        $authenticatedUser = Auth::user();
        if ($authenticatedUser->type === "Customer") {

            if ($size) {
                $invoices = Invoice::where('customer_id', '=', $authenticatedUser->id)->with('customer')->paginate($size);

            } else {
                $invoices = Invoice::where('customer_id', '=', $authenticatedUser->id)->with('customer')->paginate();

            }
            return response()->json(['message' => 'success', 'data' => $invoices], 200);
        } else {
            return response()->json(['error' => 'error', 'message' => 'No invoice found'], 404);

        }



    }
}