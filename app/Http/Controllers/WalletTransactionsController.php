<?php

namespace App\Http\Controllers;

use App\Models\WalletTransactions;
use App\Http\Requests\StoreWalletTransactionsRequest;
use App\Http\Requests\UpdateWalletTransactionsRequest;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class WalletTransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authenticatedUser = Auth::user();

        if ($authenticatedUser->type === "Admin") {

            $walletTransactions = WalletTransactions::get();
            return response()->json(['success' => "success", 'data' => $walletTransactions], 200);
        }
        if ($authenticatedUser->type === "Customer") {
            $walletTransactions = WalletTransactions::where("customer_id", $authenticatedUser->id)->get();
            return response()->json(['success' => "success", 'data' => $walletTransactions], 200);
        }
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
    public function store(StoreWalletTransactionsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function myCummulativeTransactions()
    {

        $authenticatedUser = Auth::user();
        $customer = Customer::withSum('walletTransactions', 'amount')
            ->find($authenticatedUser->id);

        $cumulativeAmount = $customer->wallet_transactions_sum_amount;
        $cumulativeAmountRounded = round($cumulativeAmount, 4);

        return response()->json(['success' => "success", 'data' => $cumulativeAmountRounded], 200);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WalletTransactions $walletTransactions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWalletTransactionsRequest $request, WalletTransactions $walletTransactions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WalletTransactions $walletTransactions)
    {
        //
    }
}