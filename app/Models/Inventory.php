<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'product_description',
        'quantity',
        'warehouse_id',
    ];
    
    public function customer()
    {
        return $this->belongsTo((Customer::class));
    }
    public function warehouse()
    {
        return $this->belongsTo((Warehouse::class));
    }


    public function activityData(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'data');
    }
}