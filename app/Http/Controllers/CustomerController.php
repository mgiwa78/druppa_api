<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of thCustomere resource.
     */
    public function fetchCustomerProfiles(Customer $customer)
    {
        // $pageSize = $size === 10 ? 0 : (int) $size;

        // if ($pageSize) {
        //     $customer_users = Customer::with('permissions')->paginate();
        //     return response()->json(['success' => "success", 'customer_users' => $customer_users], 201);

        // } else {
        $customer_users = Customer::all();
        return response()->json(['success' => "success", 'customer_users' => $customer_users], 201);

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
        $customer->firstName =$request->firstName;
        $customer->lastName =$request->lastName;
        $customer->gender =$request->gender;
        $customer->type = 'Customer';
        $customer->title =$request->title;
        $customer->email =$request->email;
        $customer->phone_number =$request->phone_number;
        $customer->address =$request->address;
        $customer->city =$request->city;
        $customer->state =$request->state;
        $customer->password = bcrypt($request->password);

        $customer->save();

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
            return response()->json(['error' => "error", 'message' => "No User found"], 200);
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
    public function updateCustomerProfile(UpdateCustomerRequest $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        $customer->update([
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'gender' => $request->gender,
            'title' => $request->title,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
        ]);

        return response()->json(['success' => 'Customer updated successfully', 'customer' => $customer], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfile(UpdateUserRequest $request, Customer $customer)
    {

        $validation = Validator::make($request->all(), [
            'id' => 'required|integer|max:150',
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 422);
        } else {
            $id = $request->id;
            $user = Customer::where('id', $id)->first();

            if ($request->file('profile')) {

                $file = $request->file('profile');
                $file_name = hexdec(uniqid()) . '.' . $file->extension();
                $file->move('./storage/druppa_customer_profiles', $file_name);
                $user->profile = '/storage/druppa_customer_profiles/' . $file_name;
            }

            $user->name = $request->name;
            $user->phone_number = $request->phone_number;
            $user->address = $request->address;
            $user->type = $request->type;
            $user->gender = $request->gender;
            $user->state = $request->state;

            $user->save();

        }

    }

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
}