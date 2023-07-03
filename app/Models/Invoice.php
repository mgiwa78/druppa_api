<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo(Customer::class, );
    }
    public function customer_order()
    {
        return $this->belongsTo(CustomerOrder::class, );
    }
    // public function payment()
    // {
    //     return $this->belongsTo(Payment::class, );
    // }
}