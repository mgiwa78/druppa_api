<?php

namespace App\Http\Controllers;

use App\Models\VendorItem;
use App\Http\Requests\StoreVendorItemRequest;
use App\Http\Requests\UpdateVendorItemRequest;
use Illuminate\Support\Facades\Auth;

class VendorItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
           $authenticatedUser = Auth::user();

           if($authenticatedUser->type==="Admin"){
 $vendorItems = VendorItem::all()->paginate();
  return response()->json(['success' => "success", 'data' => $vendorItems], 200);
           }  if($authenticatedUser->type==="Vendor"){
             $vendorItems = VendorItem::where("vendor_id",$authenticatedUser->id)->paginate();
              return response()->json(['success' => "success", 'data' => $vendorItems], 200);
           }
       

       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVendorItemRequest $request)
    {
        $newVendorItem = new VendorItem();

        $newVendorItem->name = $request->name;
        $newVendorItem->description = $request->description;
        $newVendorItem->price = $request->price;
        $newVendorItem->vendor_id = $request->vendor_id;
        $newVendorItem->vendor_item_category_id = $request->vedor_item_category_id;
        $profile = NULL;

        if ($request->file('image')) {

            $file = $request->file('image');
            $file_name = hexdec(uniqid()) . '.' . $file->extension();
            $file->move('./storage/druppa_vendor_images', $file_name);
            $profile = '/storage/druppa_vendor_images/' . $file_name;
        }

        $newVendorItem->image = $profile;
$newVendorItem->save();

        return response()->json(['success' => "success", 'data' => $newVendorItem], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(VendorItem $vendorItem, $id)
    {
        $vendorItemResult = $vendorItem->find($id);
        if ($vendorItemResult) {
            return response()->json(['success' => "success", 'data' => $vendorItemResult], 200);

        } else {
            return response()->json(['success' => "success", 'message' => "Vendor Item not found"], 200);

        }

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VendorItem $vendorItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVendorItemRequest $request)
    {

     $id = $request->id;
        $vendorItem = VendorItem::find($id)->first();

        $vendorItem->name = $request->name;
        $vendorItem->description = $request->description;
        $vendorItem->price = $request->price;
        $vendorItem->vendor_item_category_id = $request->vendor_item_category_id;


        $vendorItem->save();

        return response()->json(['success' => "success", 'data' => $vendorItem], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VendorItem $vendorItem)
    {
        //
    }
}