<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Inventory;
use App\Models\CustomerActivity;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Requests\StoreInventoryRequest;
use App\Http\Requests\StoreInventoryRequestRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\ActivityLog;
use App\Models\InventoryRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CustomerController extends Controller
{
    /**
     * Customer Log Activities.
     */


    public function requestInventory(StoreInventoryRequestRequest $request, $id)
    {
        // Retrieve the customer with the given ID
        $customer = Customer::findOrFail($id);

        // Create a new inventory for the customer
        $inventory_request = new InventoryRequest();
        $inventory_request->customer_id = $customer->id;

        $inventory_request->request_description = $request->request_description;
        $inventory_request->quantity = $request->quantity;
        $inventory_request->pickup_address = $request->pickup_address;

        $inventory_request->save();

        // Return a response indicating the success
        return response()->json(['success' => true, 'data' => $inventory_request], 201);
    }
    public function getInventoryRequests()
    {
        $authenticatedUser = Auth::user();
        // Retrieve the customer with the given ID

        // Create a new inventory for the customer
        $inventory_request = InventoryRequest::where("customer_id", "=", $authenticatedUser->id)->get();



        return response()->json(['success' => true, 'data' => $inventory_request], 200);
    }
    /**
     * Display a listing of thCustomere resource.
     */
    public function fetchCustomerProfiles()
    {
        $authenticatedUser = Auth::user();

        $assignedLocation = $authenticatedUser->location_id;

        $customer_users = Customer::where("location_id", $assignedLocation)->with("customerLocation")->get();


        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);


        $activityLog->description = "Get All Customers";

        $activityLog->save();
        return response()->json(['success' => "success", 'data' => $customer_users], 200);

        // }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {

        $request->validated();

        // Create a new customer instance
        $customer = new Customer();
        $customer->firstName = $request->firstName;
        $customer->lastName = $request->lastName;
        $customer->gender = $request->gender;
        $customer->type = 'Customer';
        $customer->title = $request->title;
        $customer->email = $request->email;
        $customer->phone_number = $request->phone_number;
        $customer->address = $request->address;
        $customer->city = $request->city;
        $customer->password = bcrypt($request->password);

        $customer->save();


        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($customer);


        $activityLog->description = "Create New Customer";

        $activityLog->save();

        return response()->json(['success' => 'Customer created successfully'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function fetchProfile($id, Request $request)
    {

        $user = Customer::find($id);



        if ($user) {
            return response()->json(['success' => "success", 'user' => $user], 200);
        } else {
            return response()->json(['error' => "error", 'message' => "No User found"], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified Customer resource in storage.
     */
    // public function updateCustomerProfile(UpdateCustomerRequest $request, Customer $customer)

    // {
    //     $customer->id = $request->id;
    //     $customer->firstName = $request->firstName;
    //     $customer->lastName = $request->lastName;
    //     $customer->gender = $request->gender;
    //     $customer->type = $request->type;
    //     $customer->title = $request->title;
    //     $customer->email = $request->email;
    //     $customer->phone_number = $request->phone_number;
    //     $customer->address = $request->address;
    //     $customer->city = $request->city;
    //     $customer->state = $request->state;
    //     $customer->password = bcrypt($request->password); // Assuming you want to hash the password

    //     $customer->save();

    //     return response()->json(['success' => 'Customer profile updated successfully', 'customer' => $customer], 200);
    // }
    public function updateCustomerProfile(UpdateCustomerRequest $request)
    {


        $authenticatedUser = Auth::user();
        $customer = Customer::find($authenticatedUser->id);



        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }
        $profile = NULL;
        if ($request->file('profile')) {

            $file = $request->file('profile');
            $file_name = hexdec(uniqid()) . '.' . $file->extension();
            $file->move('./storage/druppa_customer_profiles', $file_name);
            $profile = '/storage/druppa_customer_profiles/' . $file_name;
        }




        $customer->update([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'gender' => $request->gender,
            'title' => $request->title,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'city' => $request->city,
            'profile' => $profile,
        ]);

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($customer);


        $activityLog->description = "Customer Profile Updated";

        $activityLog->save();
        return response()->json(['success' => 'Customer updated successfully', 'customer' => $customer], 200);
    }

    /**
     * Update the specified resource in storage.
     */

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }
        $customer->delete();

        return response()->json(['success' => 'Customer deleted successfully'], 200);
    }

    /**
     * Get the count of customers.
     */
    public function getCustomerCount()
    {
        $count = Customer::count();
        return response()->json(['count' => $count], 200);
    }
}