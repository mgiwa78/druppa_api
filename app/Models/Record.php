<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    protected $fillable = ['product_id', 'action', 'quantity', 'address'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}