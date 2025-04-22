<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // allow mass assignment on name, number, and most_recent_order_id
    protected $fillable = [
        'name',
        'number',
        'most_recent_order_id',
    ];

    /**
     * The “most recent order” relationship.
     * Assumes you have an Order model in App\Models\Order.
     */
    public function mostRecentOrder()
    {
        return $this->belongsTo(Order::class, 'most_recent_order_id');
    }
}


