<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\ActivityLog;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\CustomerOrder;
use App\Models\Delivery;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function fetchDriverProfiles()
    {
        $authenticatedUser = Auth::user();
        $assignedLocation = $authenticatedUser->location_id;

        $drivers = Driver::where("location_id", $assignedLocation)->with("driverLocation")->get();



        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);


        $activityLog->description = "Access Driver Profiles";

        $activityLog->save();

        return response()->json(['success' => 'success', 'data' => $drivers], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('drivers.create');
    }
    public function stateUpdate(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'isActive' => 'required|boolean',
        ]);
        if ($validation->fails()) {
            return response()->json(['error' => $validation->errors()], 422);
        } else
            $authenticatedUser = Auth::user();
        $user = Driver::find($authenticatedUser->id);

        $user->isActive = $request->isActive;
        $user->save();


        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($user);


        $activityLog->description = "Driver Updated Their Active State";

        $activityLog->save();
        return response()->json(['user' => $authenticatedUser]);

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDriverRequest $request)
    {
        $validatedData = $request->validated();

        $driver = new Driver();
        $driver->firstName = $validatedData['firstName'];
        $driver->lastName = $validatedData['lastName'];
        $driver->email = $validatedData['email'];
        $driver->gender = $validatedData['gender'];
        $driver->title = $validatedData['title'];
        $driver->phone_number = $validatedData['phone_number'];
        $driver->type = $validatedData['type'];
        $driver->address = $validatedData['address'];

        $driver->city = $validatedData['city'];
        $driver->state = $validatedData['state'];
        $driver->licenseNumber = $validatedData['licenseNumber'];
        $driver->licenseExpiration = $validatedData['licenseExpiration'];
        $driver->vehicleMake = $validatedData['vehicleMake'];
        $driver->vehicleModel = $validatedData['vehicleModel'];
        $driver->licensePlate = $validatedData['licensePlate'];
        $driver->password = bcrypt($validatedData['password']);

        $driver->save();


        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($driver);


        $activityLog->description = "Create Driver Profile";

        $activityLog->save();
        return response()->json(['message' => 'Driver created successfully', 'driver' => $driver]);
    }
    public function updateDriver(UpdateDriverRequest $request, $id)
    {
        $request->validated();

        $driver = Driver::find($id);
        $driver->firstName = $request->firstName;
        $driver->lastName = $request->lastName;
        $driver->email = $request->email;

        $driver->gender = $request->gender;
        $driver->title = $request->title;
        $driver->phone_number = $request->phone_number;
        $driver->city = $request->city;
        $driver->state = $request->state;
        $driver->allowEdit = $request->allowEdit;

        $driver->licenseNumber = $request->licenseNumber;
        $driver->licenseExpiration = $request->licenseExpiration;
        $driver->vehicleMake = $request->vehicleMake;
        $driver->vehicleModel = $request->vehicleModel;
        $driver->licensePlate = $request->licensePlate;
        $driver->insurance = $request->insurance;
        // $driver->password = bcrypt($request->password);

        $driver->save();


        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($driver);


        $activityLog->description = "Create Driver Profile";

        $activityLog->save();

        return response()->json(['message' => 'Driver updated successfully', 'driver' => $driver]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $driver = Driver::find($id);


        $authenticatedUser = Auth::user();

        $activityLog = new ActivityLog();

        $activityLog->user()->associate($authenticatedUser);
        $activityLog->data()->associate($driver);


        $activityLog->description = "Retreive Driver Profile";

        $activityLog->save();

        if ($driver) {
            return response()->json(['success' => "success", 'data' => $driver], 200);
        } else {
            return response()->json(['error' => "error", 'message' => "No driver found"], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function updateDriverProfile(UpdateDriverRequest $request)
    {

        $request->validated();

        $authenticatedUser = Auth::user();
        $driver = Driver::find($authenticatedUser->id);



        if ($driver) {
            $profile = NULL;

            if ($request->file('profile')) {

                $file = $request->file('profile');
                $file_name = hexdec(uniqid()) . '.' . $file->extension();
                $file->move('./storage/druppa_customer_profiles', $file_name);
                $profile = '/storage/druppa_customer_profiles/' . $file_name;
            }

            $driver->lastName = $request->lastName;
            $driver->gender = $request->gender;
            $driver->title = $request->title;
            $driver->allowEdit = $request->allowEdit;
            $driver->phone_number = $request->phone_number;
            $driver->city = $request->city;
            $driver->state = $request->state;

            $driver->licenseNumber = $request->licenseNumber;
            $driver->licenseExpiration = $request->licenseExpiration;
            $driver->vehicleMake = $request->vehicleMake;
            $driver->vehicleModel = $request->vehicleModel;
            $driver->licensePlate = $request->licensePlate;
            $driver->insurance = $request->insurance;
            $driver->profile = $profile;

            $driver->save();


            $authenticatedUser = Auth::user();

            $activityLog = new ActivityLog();

            $activityLog->user()->associate($authenticatedUser);
            $activityLog->data()->associate($driver);


            $activityLog->description = "Driver Profile Updated";

            $activityLog->save();

            return response()->json(['message' => 'Driver updated successfully', 'data' => $driver]);
        } else {
            return response()->json(['error' => 'error', 'message' => 'No driver found'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $driver = Driver::find($id);

        if ($driver) {
            $driver->delete();


            $authenticatedUser = Auth::user();

            $activityLog = new ActivityLog();

            $activityLog->user()->associate($authenticatedUser);
            $activityLog->data()->associate($driver);


            $activityLog->description = "Driver Profile Deleted";

            $activityLog->save();
            return response()->json(['message' => 'Driver deleted successfully']);
        } else {
            return response()->json(['error' => 'Driver not found']);
        }
    }

    /**
     * Get all drivers count.
     */
    public function getDriverCount()
    {
        $count = Driver::count();
        return response()->json(['count' => $count], 200);
    }
    public function verifyPickup(Request $request)
    {

        $authenticatedUser = Auth::user();
        if ($authenticatedUser->type === "Driver") {

            $tracking_number = $request->tracking_number;

            $delivery = Delivery::where("tracking_number", $tracking_number)->first();

            if ($delivery) {
                if ($delivery->status === "Pending Pickup") {
                    $delivery->status = "In Transit";
                    $delivery->pickup_date = Carbon::now();
                    $delivery->save();

                    $order = CustomerOrder::find($delivery->customer_order_id);
                    $order->status = "In Transit";

                    return response()->json(['success' => 'success', 'message' => 'Pickup Updated Successfully'], 200);
                } else {
                    return response()->json(['error' => 'error', 'message' => 'Invalid Tracking Number'], 404);
                }
            } else {
                return response()->json(['error' => 'error', 'message' => 'Invalid Tracking Number'], 404);
            }

        } else {
            return response()->json(['error' => 'error', 'message' => 'You are not permitted'], 402);

        }
    }

    public function verifyDropOff(Request $request)
    {

        $authenticatedUser = Auth::user();
        if ($authenticatedUser->type === "Driver") {

            $tracking_number = $request->tracking_number;

            $delivery = Delivery::where("tracking_number", $tracking_number)->first();

            if ($delivery) {
                if (true) {
                    $delivery->status = "Delivered";

                    $order = CustomerOrder::find($delivery->customer_order_id);
                    $order->status = "Delivered";
                    $order->save();

                    $delivery_date = Carbon::now();

                    $delivery->delivery_date = $delivery_date;
                    $pickup_date = Carbon::parse($delivery->pickup_date);

                    $interval = $pickup_date->diff($delivery_date);
                    $totalMinutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;


                    $delivery->time_taken = $totalMinutes;

                    $delivery->save();

                    return response()->json(['success' => 'success', 'message' => 'Shipment Delivered'], 200);
                } else {
                    return response()->json(['error' => 'error', 'message' => 'Invalid Tracking Number'], 404);
                }
            } else {
                return response()->json(['error' => 'error', 'message' => 'Invalid Tracking Number'], 404);
            }

        } else {
            return response()->json(['error' => 'error', 'message' => 'You are not permitted'], 402);

        }
    }
    public function getDriverStatics()
    {
        $authenticatedUser = Auth::user();
        if ($authenticatedUser->type === "Driver") {
            $driverId = $authenticatedUser->id;

            $totalDeliveries = Delivery::where('driver_id', $driverId)->where('status', "Delivered")->count();
            $totalDistance = 0;
            $performanceRate = 0;
            if ($totalDeliveries) {
                $Data = Delivery::where('driver_id', $driverId)->with("customer_order")->get();

                $totalDistance = $Data->sum(function ($delivery) {
                    return $delivery->customer_order->distance;
                });

                $totalTime = $Data->sum('time_taken');

                $performanceRate = ($totalDistance / $totalTime) * $totalDeliveries;

            }
            return response()->json([
                'message' => 'success',
                'data' => [
                    'total_deliveries' => $totalDeliveries,
                    'total_distance' => $totalDistance,
                    'performance' => $performanceRate,
                ]
            ], Response::HTTP_OK);
        } else {
            return response()->json(['error' => 'error', 'message' => 'No driver found'], 404);

        }
    }
}