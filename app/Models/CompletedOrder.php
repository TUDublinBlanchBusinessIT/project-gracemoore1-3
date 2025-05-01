<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Model;
    
    class CompletedOrder extends Model
    {
        protected $fillable = [
            'order_id',
            'total_price',
            'items_ordered',
            'customer_id',
        ];
    
        public function order()
        {
            return $this->belongsTo(Order::class, 'order_id');
        }
    
        public function customer()
        {
            return $this->belongsTo(Customer::class, 'customer_id'); // Assuming customers are in the customers table
        }
    }