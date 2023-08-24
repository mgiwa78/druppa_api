<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorItem extends Model
{

    use HasFactory;
    public function category()
    {

        return $this->belongsTo(VendorItemCategory::class, "vendor_item_category_id");

    }
    public function vendor()
    {

        return $this->belongsTo(Vendor::class);

    }

}