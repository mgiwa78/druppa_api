<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, HasApiTokens;

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function activityData(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'data');
    }
    public function activityPerformer(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'user');
    }
}