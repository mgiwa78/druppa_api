<?php

namespace App\Policies;

use App\Models\Delivery;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DeliveryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewDeliveries(Driver $user)
    {
        return $user->type === 'Driver';
    }

    /**
     * Determine whether the user can view the model.
     */

}