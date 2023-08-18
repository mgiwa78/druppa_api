<?php

namespace App\Http\Controllers;

use App\Models\VendorItemCategory;
use App\Http\Requests\StoreVendorItemCategoryRequest;
use App\Http\Requests\UpdateVendorItemCategoryRequest;

class VendorItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $vendorItemCtegories = VendorItemCategory::all();
    return response()->json(['success' => "success", 'data' => $vendorItemCtegories], 200);

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
    public function store(StoreVendorItemCategoryRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(VendorItemCategory $vendorItemCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VendorItemCategory $vendorItemCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendorItemCategoryRequest $request, VendorItemCategory $vendorItemCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VendorItemCategory $vendorItemCategory)
    {
        //
    }
}
