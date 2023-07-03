<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CustomerOrder extends Model
{
    use HasFactory;

    public function customer()
    {
        return $this->belongsTo((Customer::class));
    }
    // public function delivery()
    // {
    //     return $this->hasOne((Delivery::class));
    // }
    public function payment()
    {
        return $this->hasOne((Payment::class));
    }
    public function activityData(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'data');
    }

}