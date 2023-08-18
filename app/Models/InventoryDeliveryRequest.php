<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryDeliveryRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'requestDescription',
        'deliveryAddress',
        'inventory_id',
        'requestQuantity',
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}