<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; 
use App\Models\User;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id',
        'user_id',
        'pickup_datetime',
        'total_price',
        'list_of_items',
        'special_requests',
    ];
  

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }




}
