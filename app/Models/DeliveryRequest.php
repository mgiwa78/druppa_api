<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryRequest extends Model
{
    protected $fillable = [
        'inventory_id',
        'customer_id',
        'address',
        'quantity_requested',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
