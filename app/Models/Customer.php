<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // allow mass‑assignment on name & number
    protected $fillable = ['name', 'number'];

    // define the mostRecentOrder relationship
    public function mostRecentOrder()
    {
        return $this->belongsTo(Order::class, 'most_recent_order_id');
    }
}
