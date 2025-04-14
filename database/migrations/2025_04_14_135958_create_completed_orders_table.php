<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompletedOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('completed_orders', function (Blueprint $table) {
            $table->id(); // Primary key for the completed order record
            $table->decimal('total_price', 8, 2);
            $table->text('list_of_items');
            // Foreign key: the order from the orders table that is now completed
            $table->unsignedBigInteger('order_id');
            // Foreign key: the customer id from the customers table
            $table->unsignedBigInteger('customer_id');
            $table->timestamps();

            // Foreign key constraints.
            $table->foreign('order_id')
                  ->references('id')->on('orders')
                  ->onDelete('cascade');
            $table->foreign('customer_id')
                  ->references('id')->on('customers')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('completed_orders');
    }
}

