<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetainershipInstance extends Model
{
    use HasFactory;
    protected $fillable = [
        'retainership_id',
        'customer_order_id',
    ];
    public function retainership()
    {
        return $this->belongsTo(RetainershipInstance::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}