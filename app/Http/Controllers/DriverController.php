<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Http\Requests\StoreDriverRequest;
use App\Http\Requests\UpdateDriverRequest;
use Illuminate\Http\Request;


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
    public function edit($id)
    {
        $driver = Driver::find($id);

        if ($driver) {
            return view('drivers.edit', compact('driver'));
        } else {
            return response()->json(['error' => 'error', 'message' => 'No driver found'], 200);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateDriverProfile(UpdateDriverRequest $request, $id)
    {
        $validatedData = $request->validated();

        $driver = Driver::find($id);

        if ($driver) {
            $driver->update([
                'firstName' => $validatedData['firstName'],
                'lastName' => $validatedData['lastName'],
                'email' => $validatedData['email'],
                'gender' => $validatedData['gender'],
                'title' => $validatedData['title'],
                'phone_number' => $validatedData['phone_number'],
                'type' => $validatedData['type'],
                'city' => $validatedData['city'],
                'state' => $validatedData['state'],
                'licenseNumber' => $validatedData['licenseNumber'],
                'licenseExpiration' => $validatedData['licenseExpiration'],
                'vehicleMake' => $validatedData['vehicleMake'],
                'vehicleModel' => $validatedData['vehicleModel'],
                'licensePlate' => $validatedData['licensePlate'],
                'insurance' => $validatedData['insurance'],
                'password' => bcrypt($validatedData['password']),
            ]);

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
}