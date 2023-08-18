<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function deposit(Request $request)
    {
        $authenticatedUser = Auth::user();

        $amount = $request->amount;

        $customer = Customer::find($authenticatedUser->id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        if (!$customer->wallet) {
            $wallet = new Wallet(['balance' => 0]);
            $customer->wallet()->save($wallet);
        }

        $wallet = $customer->wallet;

        $wallet->deposit((int) $amount);

        return response()->json(['success' => "success", 'data' => $wallet], 200);

    }


    public function withdraw(Request $request)
    {
        $customerId = $request->input('customer_id');
        $amount = $request->input('amount');

        $customer = Customer::find($customerId);
        $wallet = $customer->wallet;

        if ($wallet->balance < $amount) {
            return response()->json(['message' => 'Insufficient balance.'], 400);
        }

        $wallet->withdraw($amount);

        return response()->json(['message' => 'Wallet successfully withdrawn.'], 200);
    }

    public function balance($id)
    {
        $wallet = Wallet::where("customer_id", $id)->first();
        if ($wallet) {
            return response()->json(['success' => "success", 'data' => $wallet->balance], 200);
        } else {
            return response()->json(['success' => "success", 'data' => 0], 200);
        }
    }
}