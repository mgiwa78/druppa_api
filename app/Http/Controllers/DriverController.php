<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Delivery;
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
        $drivers = Driver::all();
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
        $driver->city = $validatedData['city'];
        $driver->state = $validatedData['state'];
        $driver->licenseNumber = $validatedData['licenseNumber'];
        $driver->licenseExpiration = $validatedData['licenseExpiration'];
        $driver->vehicleMake = $validatedData['vehicleMake'];
        $driver->vehicleModel = $validatedData['vehicleModel'];
        $driver->licensePlate = $validatedData['licensePlate'];
        $driver->insurance = $validatedData['insurance'];
        $driver->password = bcrypt($validatedData['password']);

        $driver->save();

        return response()->json(['message' => 'Driver created successfully', 'driver' => $driver]);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $driver = Driver::find($id);

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

    public function getDriverStatics()
    {
        $authenticatedUser = Auth::user();
        if ($authenticatedUser->type === "Driver") {
            $driverId = $authenticatedUser->id;

            $totalDeliveries = Delivery::where('driver_id', $driverId)->count();
            $totalDistance = Delivery::where('driver_id', $driverId)->sum('distance');
            $totalTime = Delivery::where('driver_id', $driverId)->sum('time_taken');

            $performance = DB::table('deliveries')
                ->selectRaw('SUM(time_taken) AS total_time, SUM(distance) AS total_distance, COUNT(*) AS total_deliveries')
                ->where('driver_id', $driverId)
                ->first();
            $performanceRate = ($totalDistance / $totalTime) * $totalDeliveries;

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