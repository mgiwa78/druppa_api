<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\ActivityLog;
use App\Models\Customer;
use App\Models\CustomerOrder;
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
    public function test()
    {
            $admin_users = Admin::get();
            return response()->json(['success' => "success", 'data' => $admin_users], 200);

    }
    public function fetchAdminProfiles()
    {
        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);

        $activityLog->description = "Access Admin Profiles";

        $activityLog->save();

        $pageSize = 10;

        if ($pageSize) {
            $admin_users = Admin::with('permissions')->paginate($pageSize);
            return response()->json(['success' => "success", 'data' => $admin_users], 200);

        } else {
            $admin_users = Admin::with('permissions')->paginate();
            return response()->json(['success' => "success", 'data' => $admin_users], 200);

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

            $authenticatedUser = Auth::user();

            $activityLog = new ActivityLog();

            $activityLog->user()->associate($authenticatedUser);
            $activityLog->data()->associate($admin);

            $activityLog->description = "Admin profile Created";

            $activityLog->save();


        }
    }
    public function edit(Request $request)
    {


        $admin = Admin::find($request->id);

        $validation = Validator::make($request->all(), [
            'firstName' => 'required|string|max:150',
            'lastName' => 'required|string|max:150',
            'phone_number' => 'required|string|max:150',
            'email' => 'email|string|max:150',

        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 422);
        } else {

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

            $admin->phone_number = $request->phone_number;



            if ($request->permissions) {
                $permissions = explode(",", $request->permissions);
                $id = $admin->id;


                foreach ($permissions as $key => $permission) {
                    $perm = new Permission;
                    $perm->admin_id = $id;

                    $check = Permission::where("admin_id", "=", "$id")->where("permission", "=", "$permission")->where("status", "=", "Active")->exists();

                    if ($check) {
                        return response()->json(['error' => 'error', 'message' => "Permission: $permission already assigned"], 404);
                    }
                    $perm->status = "Active";
                    $perm->permission = $permission;
                    $perm->save();
                }
            }
            $admin->save();

            $authenticatedUser = Auth::user();

            $activityLog = new ActivityLog();

            $activityLog->user()->associate($authenticatedUser);
            $activityLog->data()->associate($admin);

            $activityLog->description = "Admin profile Created";

            $activityLog->save();

            return response()->json(['success' => "success", 'message' => "Admin Updated"], 200);

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

        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($admin);

        $activityLog->description = "Retrive Admin Profile";

        $activityLog->save();

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
        $adminCount = Admin::count();
        $activeDriverCount = Driver::where('isActive', '1')->count();
        $inActiveDriverCount = Driver::where('isActive', '0')->count();
        $driverCount = Driver::count();
        $customerCount = Customer::count();
        $pendingCustomerOrderCount = CustomerOrder::where('status', 'Pending')->count();
        $CustomerOrderCount = CustomerOrder::count();
        $transitCustomerOrderCount = CustomerOrder::where('status', 'In Transit')->count();

        $adminStatics = [
            'admin' => $adminCount,
            'driver' => $driverCount,
            'customer' => $customerCount,
            'inActiveDrivers' => $inActiveDriverCount,
            'activeDrivers' => $activeDriverCount,
            'customerOrders' => $CustomerOrderCount,
            'pendingCustomerOrders' => $pendingCustomerOrderCount,
            'transitCustomerOrders' => $transitCustomerOrderCount,
        ];

        return response()->json(['success' => "success", 'data' => $adminStatics], 200);
    }
}