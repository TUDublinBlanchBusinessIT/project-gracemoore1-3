<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // Primary Key: order number/id
            // Foreign key: the customer who places the order
            $table->unsignedBigInteger('customer_id');
            $table->dateTime('pickup_datetime');
            $table->decimal('total_price', 8, 2);
            // We store a list of items (for example as JSON) in this text field.
            $table->text('list_of_items');
            // Foreign key: the employee id who took the order; can be nullable if not yet assigned.
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->timestamps();

            // Set up foreign key constraints.
            $table->foreign('customer_id')
                  ->references('id')->on('customers')
                  ->onDelete('cascade');

            $table->foreign('employee_id')
                  ->references('id')->on('employees')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}


