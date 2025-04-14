<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id(); // Primary key: customer id
            $table->string('name');
            $table->string('number'); // phone number
            // Most recent order (nullable foreign key to orders table)
            $table->unsignedBigInteger('most_recent_order_id')->nullable();
            $table->foreign('most_recent_order_id')
                  ->references('id')
                  ->on('orders')
                  ->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
}


