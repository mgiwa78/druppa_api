<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstName',
        'lastName',
        'gender',
        'type',
        'title',
        'email',
        'phone_number',
        'address',
        'city',
        'state',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function delivery()
    {
        return $this->hasMany(Delivery::class);
    }
    public function inventries()
    {
        return $this->hasMany(Inventory::class);
    }
    public function deliveryRequests()
    {
        return $this->hasMany(DeliveryRequest::class);
    }
    public function orders()
    {
        return $this->hasMany(CustomerOrder::class);
    }
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
    public function invoice()
    {
        return $this->hasMany(Invoice::class);
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