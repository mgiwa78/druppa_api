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
        'balance',
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

    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    public function couponRecords()
    {
        return $this->hasMany(CouponRecords::class, 'customer_id');
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
    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
    public function assignedLocation()
    {
        return $this->hasOne(Admin::class);
    }
    public function customerLocation()
    {
        return $this->belongsTo(Location::class);
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

    public function inventoryDeliveryRequest()
    {
        return $this->hasMany(InventoryDeliveryRequest::class);
    }
    public function walletTransactions()
    {
        return $this->hasMany(WalletTransactions::class, 'customer_id');
    }
}