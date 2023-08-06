<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'balance',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function deposit($amount)
    {
        $this->balance += $amount;
        $this->save();
    }

    public function withdraw($amount)
    {
        $this->balance -= $amount;
        $this->save();
    }
}

