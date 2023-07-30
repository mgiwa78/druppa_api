<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetainershipCustomer extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'contract_start_date',
        'contract_end_date',
        'discount_percentage',
    ];
}
