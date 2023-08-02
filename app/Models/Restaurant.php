<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'address', 'contact_number'];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
