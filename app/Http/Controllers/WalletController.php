<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\Customer;

class WalletController extends Controller
{
    public function deposit(Request $request)
    {
        $customerId = $request->input('customer_id');
        $amount = $request->input('amount');

        $customer = Customer::find($customerId);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found.'], 404);
        }

        // Check if the customer has a wallet. If not, create a new one.
        if (!$customer->wallet) {
            $wallet = new Wallet(['balance' => 0]);
            $customer->wallet()->save($wallet);
        }

        $wallet = $customer->wallet;

        $wallet->deposit($amount);

        return response()->json(['message' => 'Wallet successfully deposited.'], 200);
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
        $wallet = Wallet::findOrFail($id);

        return response()->json(['balance' => $wallet->balance], 200);
    }
}
