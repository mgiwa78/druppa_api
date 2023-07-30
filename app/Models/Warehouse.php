<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location', 'capacity'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function Inventory()
    {
        return $this->hasMany(Inventory::class);
    }

    public function activityData(): MorphMany
    {
        return $this->morphMany(ActivityLog::class, 'data');
    }
}