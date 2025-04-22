<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function mostRecentOrder()
    {
        return $this->belongsTo(Order::class, 'most_recent_order_id');
    }
}

