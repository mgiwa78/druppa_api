<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RetainershipCustomer;

class RetainershipCustomerController extends Controller
{
    public function index()
    {
        $retainershipCustomers = RetainershipCustomer::all();
        return response()->json([ 'success' => "success", 'data' => $retainershipCustomers, 'message' => 'Retainership customers retrieved successfully.', ], 200);
    }

    public function show($id)
    {
        $retainershipCustomer = RetainershipCustomer::find($id);
        return response()->json([ 'success' => "success", 'data' => $retainershipCustomer, 'message' => 'Retainership customer retrieved successfully.', ], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date',
            'discount_percentage' => 'required|numeric',
        ]);

        $retainershipCustomer = RetainershipCustomer::create($validatedData);
        return response()->json([ 'success' => "success", 'data' => $retainershipCustomer, 'message' => 'Retainership customer created successfully.', ], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string',
            'contract_start_date' => 'required|date',
            'contract_end_date' => 'required|date',
            'discount_percentage' => 'required|numeric',
        ]);

        $retainershipCustomer = RetainershipCustomer::findOrFail($id);
        $retainershipCustomer->update($validatedData);
        return response()->json([ 'success' => "success", 'data' => $retainershipCustomer, 'message' => 'Retainership customer updated successfully.', ], 200);
    }

    public function destroy($id)
    {
        RetainershipCustomer::findOrFail($id)->delete();
        return response()->json(['message' => 'Retainership customer deleted successfully'], 200);
    }
}
