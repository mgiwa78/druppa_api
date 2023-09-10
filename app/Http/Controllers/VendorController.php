<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Models\ActivityLog;
use App\Models\CustomerOrder;
use App\Models\VendorItem;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $authenticatedUser = Auth::user();

        $vendors = Vendor::paginate();


        return response()->json(['success' => "success", 'data' => $vendors], 200);
    }
    public function getVendorStatics()
    {
        $authenticatedUser = Auth::user();
        $vendorsItems = VendorItem::where("vendor_id", $authenticatedUser->id)->count();
        $customerOrders = CustomerOrder::where("vendor_id", $authenticatedUser->id)->count();

        $vendorStatic = [
            "vendorsItems" => $vendorsItems,
            "customerOrders" => $customerOrders,
            "sales" => $customerOrders,
        ];
        return response()->json(['success' => "success", 'data' => $vendorStatic], 200);
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
    public function store(StoreVendorRequest $request)
    {

        $newVendor = Vendor::create($request->all());
        $newVendor->password = Hash::make($request->password);
        $newVendor->save();

        return response()->json(['success' => "success", 'data' => $newVendor], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UpdateVendorRequest $request, $id)
    {

        $vendor = Vendor::find($id)->first();

        $vendor->address = $request->address;
        $vendor->email = $request->email;
        $vendor->contactInformation = $request->contactInformation;
        $vendor->vendorName = $request->vendorName;


        $vendor->save();

        return response()->json(['success' => "success", 'data' => $vendor], 200);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vendor $vendor)
    {
        //
    }
}