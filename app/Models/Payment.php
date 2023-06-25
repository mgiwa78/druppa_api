<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Payment extends Model
{
    use HasFactory;
    public function customer()
    {
        return $this->belongsTo((Customer::class));
    }
    public function activityData(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'data');
    }
}