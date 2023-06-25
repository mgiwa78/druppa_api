<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'firstName',
        'lastName',
        'email',
        'gender',
        'title',
        'phone_number',
        'type',
        'city',
        'state',
        'licenseNumber',
        'licenseExpiration',
        'vehicleMake',
        'vehicleModel',
        'licensePlate',
        'insurance',
        'password',
    ];

    public function deliveries()
    {
        return $this->hasMany((Delivery::class));
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