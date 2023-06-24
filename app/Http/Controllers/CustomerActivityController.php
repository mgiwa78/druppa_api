<?php

namespace App\Http\Controllers;

use App\Models\CustomerActivity;
use Illuminate\Http\Request;

class CustomerActivityController extends Controller
{
    public function logActivity(Request $request)
    {
        $customerId = $request->user()->id; // Assuming you have authentication set up for customers
        $activity = $request->input('activity');

        // Create a new customer activity log entry
        CustomerActivity::create([
            'customer_id' => $customerId,
            'activity' => $activity,
        ]);

        return response()->json(['message' => 'Activity logged successfully']);
    }
}
