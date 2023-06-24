<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerActivity extends Model
{
    use HasFactory;
    protected $table = 'customer_activities';

    protected $fillable = ['customer_id', 'activity'];
}
