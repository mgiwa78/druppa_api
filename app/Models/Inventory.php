<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo((Customer::class));
    }
    public function warehouse()
    {
        return $this->belongsTo((Warehouse::class));
    }
}