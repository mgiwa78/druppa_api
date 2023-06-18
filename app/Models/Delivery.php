<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    public $fillable = ['customer_id', 'tracking_number', 'origin', 'destination', 'pickup_date', 'delivery_date', 'delivery_by', 'state', 'city'];


    public function customer()
    {
        return $this->belongsTo(Customer::class, );
    }
    public function order()
    {
        return $this->belongsTo(Order::class, );
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class, );
    }
}