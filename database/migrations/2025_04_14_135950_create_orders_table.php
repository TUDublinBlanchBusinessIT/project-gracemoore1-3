// File: database/migrations/2025_04_14_135950_create_orders_table.php

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
            $table->id();  // Order ID (Primary Key)
            $table->foreignId('customer_id')->constrained()->cascadeOnDelete();
            $table->dateTime('pickup_datetime');
            $table->decimal('total_price', 8, 2);
    // allow list_of_items to be null if you’re not ready to store it yet
            $table->text('list_of_items');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null'); // instead of employee_id
            $table->timestamps();

            // Assume customer's foreign key is defined in the customers migration.
            // $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            // Omit employee foreign key for now until employees table exists.
            // Later, you can add it with a separate migration.
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



