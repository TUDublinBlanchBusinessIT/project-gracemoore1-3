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
            $table->id(); // Completed Order ID (Primary Key)
            $table->decimal('total_price', 8, 2);
            $table->text('items_ordered'); // List of items ordered (you might store a JSON string here)
            $table->unsignedBigInteger('order_id'); // Foreign key referencing orders table
            $table->unsignedBigInteger('customer_id'); // Foreign key referencing customers table
            $table->timestamps();

            // Foreign key constraints:
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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


