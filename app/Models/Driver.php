<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}