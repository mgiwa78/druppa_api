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

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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
    public function store($request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function fetchProfile($id, Request $request)
    {

        $user = User::find($id);

        if ($user) {
            return response()->json(['success' => "success", 'user' => $user], 200);
        } else {
            return response()->json(['error' => "error", 'message' => "No User found"], 200);
        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfile(UpdateUserRequest $request, User $user)
    {

        $validation = Validator::make($request->all(), [
            'id' => 'required|integer|max:150',
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 422);
        } else {
            $id = $request->id;
            $user = User::where('id', $id)->first();

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
    public function destroy($customer)
    {
        //
    }
}