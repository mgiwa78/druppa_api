<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function fetchAdminProfiles()
    {
        $pageSize = 10;

        if ($pageSize) {
            $admin_users = Admin::with('permissions')->paginate($pageSize);
            return response()->json(['success' => "success", 'data' => $admin_users], 201);

        } else {
            $admin_users = Admin::with('permissions')->paginate();
            return response()->json(['success' => "success", 'data' => $admin_users], 201);

        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'firstName' => 'required|string|max:150',
            'lastName' => 'required|string|max:150',
            'username' => 'required|string|max:150',
            'password' => 'required|string|max:150',
            'phone_number' => 'required|string|max:150',
            'email' => 'email|string|max:150',

        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 422);
        } else {
            if (Admin::where('email', $request->email)->exists()) {
                return response()->json(['error' => ['Email Already In Use']], 422);
            }
            $admin = new Admin;

            if ($request->file('profile')) {

                $file = $request->file('profile');
                $file_name = hexdec(uniqid()) . '.' . $file->extension();
                $file->move('./storage/druppa_customer_profiles', $file_name);
                $admin->profile = '/storage/druppa_customer_profiles/' . $file_name;
            }
            $admin->firstName = $request->firstName;
            $admin->lastName = $request->lastName;
            $admin->username = $request->username;
            $admin->email = $request->email;
            $admin->type = 'Admin';
            $admin->phone_number = $request->phone_number;

            $admin->password = Hash::make($request->password);


            if ($request->permissions) {
                $permissions[] = $request->permissions->json_decode();
                $id = $admin->id;


                foreach ($permissions as $key => $permission) {
                    $perm = new Permission;
                    $perm->customer_id = $id;
                    $perm->permission = $permission;
                }
            }

            $admin->save();

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdminRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin, $id)
    {
        $admin = Admin::find($id);
        return response()->json(['success' => "success", 'admin_user' => $admin], 200);


    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }

    /**
     * Get the count of drivers.
     */
    public function getDriverCount()
    {
        $driverCount = Admin::where('type', 'Driver')->count();
        return response()->json(['success' => "success", 'count' => $driverCount], 200);
    }

    /**
     * Get the count of admins.
     */
    public function getAdminStatics()
    {
        $adminCount = Admin::where('type', 'Admin')->count();
        $driverCount = Driver::where('type', 'Driver')->count();
        $customerCount = Customer::where('type', 'Customer')->count();

        $adminStatics = [
            'admin' => $adminCount,
            'driver' => $driverCount,
            'customer' => $customerCount
        ];
        return response()->json(['success' => "success", 'data' => $adminStatics], 200);
    }
}