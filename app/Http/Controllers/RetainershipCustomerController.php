<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RetainershipCustomer;

class RetainershipCustomerController extends Controller
{
    public function index()
    {
        $retainershipCustomers = RetainershipCustomer::all();
        return response()->json($retainershipCustomers);
    }

    public function show($id)
    {
        $retainershipCustomer = RetainershipCustomer::find($id);
        return response()->json($retainershipCustomer);
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
        return response()->json($retainershipCustomer, 201);
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
        return response()->json($retainershipCustomer, 200);
    }

    public function destroy($id)
    {
        RetainershipCustomer::findOrFail($id)->delete();
        return response()->json(['message' => 'Retainership customer deleted successfully'], 200);
    }
}
