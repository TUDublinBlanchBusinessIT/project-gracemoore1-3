<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'number',
        'most_recent_order_id',
    ];

    public function latestOrder()
    {
        return $this->hasOne(Order::class)->latestOfMany();
    }


   
}



