<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retainership extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'set_num_of_orders',
        'current_num_of_orders',
    ];

    public function instances()
    {
        return $this->hasMany(RetainershipInstance::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}