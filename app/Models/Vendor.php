<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Vendor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'password',
        'email',
        'vendorName',
        'contactInformation',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activityData(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'data');
    }
    public function activityPerformer(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'user');
    }
    public function items()
    {
        return $this->hasMany(VendorItem::class);
    }
    public function customer()
    {
        return $this->hasMany(VendorItem::class);
    }
}