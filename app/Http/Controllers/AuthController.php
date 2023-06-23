<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Http\Requests\UpdateEmailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'type' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 422);
        }
        $user = null;

        $credentials = $request->only('email', 'password');
        $request->type === 'Admin' ?
            $user = Admin::where('email', $credentials['email'])->first() : (
                $request->type === 'Customer' ?
                $user = Customer::where('email', $credentials['email'])->first() : $user = Driver::where('email', $credentials['email'])->first());



        if ($user) {
            if ($request->type === 'Admin') {
                if (Auth::guard('admin')->attempt($credentials)) {
                    $authenticatedUser = Auth::guard('admin')->user();
                    $token = $user->createToken('druppa::admin')->plainTextToken;

                    return response()->json(['user' => $authenticatedUser, 'token' => $token]);


                }
            }
            if ($request->type === 'Customer') {
                if (Auth::guard('customer')->attempt($credentials)) {
                    $authenticatedUser = Auth::guard('customer')->user();

                    $token = $user->createToken('druppa::customer')->plainTextToken;

                    return response()->json(['user' => $authenticatedUser, 'token' => $token]);

                }
            }
            if ($request->type === 'Driver') {
                if (Auth::guard('driver')->attempt($credentials)) {

                    $token = $user->createToken('druppa::driver')->plainTextToken;

                    $authenticatedUser = Auth::guard('driver')->user();
                    return response()->json(['user' => $authenticatedUser, 'token' => $token]);

                } else {
                    return response()->json(['message' => 'Invalid login credentials'], 401);
                }
            }



            // if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            //     $user = Auth::guard('admin')->user();
            // return response()->json(['user' => $user]);
            // } else {
            //     return response()->json(['message' => 'Invalid login credentials'], 401);
            // }
        }

        return response()->json(['message' => 'Invalid login credentials'], 401);
    }

    /**
     * Show the form for creating a new resource.
     */

    public function getProfile(Request $request)
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);

    }
    public function updateProfile(Request $request, UpdateDriverRequest $driverRequest, UpdateCustomerRequest $customerRequest)
    {
        $authenticatedUser = Auth::user();
        if ("Admin" === $authenticatedUser->type) {
            $admin = Admin::find($authenticatedUser->id);

            $validation = Validator::make($request->all(), [
                'firstName' => 'sometimes|string|max:150',
                'lastName' => 'sometimes|string|max:150',
                'phone_number' => 'sometimes|string|max:150',
                'password' => 'sometimes|max:150',
                'email' => 'string|max:150',
                'gender' => 'string|max:150',
                'title' => 'string|max:150',
                'city' => 'string|max:150',
                'state' => 'string|max:150',

            ]);

            if ($validation->fails()) {
                return response()->json(['error' => $validation->errors()], 422);
            } else {




                $admin->firstName = $request->firstName;
                $admin->lastName = $request->lastName;


                if ($request->file('profile')) {

                    $file = $request->file('profile');
                    $file_name = hexdec(uniqid()) . '.' . $file->extension();
                    $file->move('./storage/druppa_customer_profiles', $file_name);
                    $admin->profile = '/storage/druppa_customer_profiles/' . $file_name;
                }

                $admin->phone_number = $request->phone_number;

                $admin->address = $request->address;
                $admin->city = $request->city;
                $admin->state = $request->state;



                if ($request->permissions) {
                    $permissions[] = $request->permissions->json_decode();
                    $id = $admin->id;

                    foreach ($permissions as $key => $permission) {
                        $perm = new Permission;
                        $perm->customer_id = $id;
                        $perm->permission = $permission;
                    }
                    $admin->save();
                    return response()->json(['message' => 'Admin updated successfully']);

                } else {
                    $admin->save();
                }



            }
        }
        if ("Driver" === $authenticatedUser->type) {
            $driverRequest->validated();
            $driver = Driver::find($authenticatedUser->id);

            if ($driver) {

                $profile = NULL;

                if ($driverRequest->file('profile')) {

                    $file = $driverRequest->file('profile');
                    $file_name = hexdec(uniqid()) . '.' . $file->extension();
                    $file->move('./storage/druppa_customer_profiles', $file_name);
                    $profile = '/storage/druppa_customer_profiles/' . $file_name;
                }

                $driver->lastName = $driverRequest->lastName;
                $driver->firstName = $driverRequest->firstName;
                $driver->gender = $driverRequest->gender;
                $driver->title = $driverRequest->title;
                $driver->phone_number = $driverRequest->phone_number;
                $driver->city = $driverRequest->city;
                $driver->state = $driverRequest->state;

                $driver->licenseNumber = $driverRequest->licenseNumber;
                $driver->licenseExpiration = $driverRequest->licenseExpiration;
                $driver->vehicleMake = $driverRequest->vehicleMake;
                $driver->vehicleModel = $driverRequest->vehicleModel;
                $driver->licensePlate = $driverRequest->licensePlate;
                $driver->insurance = $driverRequest->insurance;
                $driver->profile = $profile;

                $driver->save();


                return response()->json(['message' => 'Driver updated successfully', 'data' => $driver]);
            } else {
                return response()->json(['error' => 'error', 'message' => 'No driver found'], 200);
            }
        }
        if ("Customer" === $authenticatedUser->type) {
            $customerRequest->validated();

            $customer = Customer::find($authenticatedUser->id);



            if ($customerRequest->file('profile')) {

                $file = $customerRequest->file('profile');
                $file_name = hexdec(uniqid()) . '.' . $file->extension();
                $file->move('./storage/druppa_customer_profiles', $file_name);
                $customer->profile = '/storage/druppa_customer_profiles/' . $file_name;
            }

            $customer->firstName = $customerRequest->firstName;
            $customer->lastName = $customerRequest->lastName;
            $customer->phone_number = $customerRequest->phone_number;
            $customer->address = $customerRequest->address;
            $customer->type = $customerRequest->type;
            $customer->gender = $customerRequest->gender;
            $customer->state = $customerRequest->state;

            $customer->save();
            return response()->json(['message' => 'Customer updated successfully']);

        }

    }
    public function updateEmail(UpdateEmailRequest $emailRequest)
    {
        $authenticatedUser = Auth::user();
        if ("Admin" === $authenticatedUser->type) {

            $credentials = $emailRequest->only('email', 'password');
            if (Auth::guard('admin')->attempt($credentials)) {


                $admin = Admin::find($authenticatedUser->id);



                $emailRequest->validated();

                if ($admin) {
                    $admin->email = $emailRequest->email;
                    $admin->save();

                    return response()->json(['message' => 'Email updated successfully', 'data' => $admin]);
                } else {
                    return response()->json(['error' => 'error', 'message' => 'No driver found'], 404);
                }
            } {
                return response()->json(['error' => 'error', 'message' => 'Invalid Password'], 404);
            }
        }
        if ("Driver" === $authenticatedUser->type) {
            $emailRequest->validated();
            $driver = Driver::find($authenticatedUser->id);

            if ($driver) {
                $driver->email = $emailRequest->email;

                $driver->save();
                return response()->json(['message' => 'Email updated successfully', 'data' => $driver]);
            } else {
                return response()->json(['error' => 'error', 'message' => 'No driver found'], 200);
            }
        }
        if ("Customer" === $authenticatedUser->type) {
            $emailRequest->validated();

            $customer = Customer::find($authenticatedUser->id);

            if ($customer) {
                $customer->email = $emailRequest->email;
                $customer->save();
                return response()->json(['message' => 'Email updated successfully', 'data' => $customer]);
            } else {
                return response()->json(['error' => 'error', 'message' => 'No driver found'], 200);
            }
        }

    }
    public function updatePassword(UpdatePasswordRequest $passwordRequest)
    {
        $authenticatedUser = Auth::user();
        if ("Admin" === $authenticatedUser->type) {

            $credentials = $passwordRequest->only('email', 'password');
            if (Auth::guard('admin')->attempt($credentials)) {

                $admin = Admin::find($authenticatedUser->id);


                $passwordRequest->validated();

                if ($admin) {
                    $admin->password = Hash::make($passwordRequest->newPassword);

                    $admin->save();

                    return response()->json(['message' => 'Email updated successfully', 'data' => $admin]);
                } else {
                    return response()->json(['error' => 'error', 'message' => 'No driver found'], 404);
                }
            } {
                return response()->json(['error' => 'error', 'message' => 'Invalid Password'], 404);
            }
        }
        if ("Driver" === $authenticatedUser->type) {
            $passwordRequest->validated();
            $driver = Driver::find($authenticatedUser->id);

            if ($driver) {
                $driver->password = Hash::make($passwordRequest->newPassword);


                $driver->save();
                return response()->json(['message' => 'Email updated successfully', 'data' => $driver]);
            } else {
                return response()->json(['error' => 'error', 'message' => 'No driver found'], 200);
            }
        }
        if ("Customer" === $authenticatedUser->type) {
            $passwordRequest->validated();

            $customer = Customer::find($authenticatedUser->id);

            if ($customer) {
                $customer->password = Hash::make($passwordRequest->newPassword);

                $customer->save();
                return response()->json(['message' => 'Email updated successfully', 'data' => $customer]);
            } else {
                return response()->json(['error' => 'error', 'message' => 'No driver found'], 200);
            }
        }

    }
    public function customerRegister(StoreCustomerRequest $request)
    {
        $request->validated();

        $authenticatedUser = Auth::user();
        $user = Admin::find($authenticatedUser->id);


        $user = new Customer;
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->email = $request->email;
        $user->title = $request->title;
        $user->gender = $request->gender;
        $user->phone_number = $request->phone_number;
        $user->password = Hash::make($request->password);
        $user->type = $request->type;

        $user->save();



        $token = $user->createToken('druppa')->plainTextToken;

        $codex = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), -63);
        $user->verify_token = Str::random(40) . $codex . time();
        $user->save();


        return response()->json(['token' => $token, 'user' => $user, 'message' => 'You have successfully created an account'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($request)
    {
        //
    }


}