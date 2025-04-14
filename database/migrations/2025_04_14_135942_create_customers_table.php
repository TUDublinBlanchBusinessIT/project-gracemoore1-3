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
            $table->id();
            $table->string('name');
            $table->string('number');
            // Originally: adding the foreign key constraint:
            // $table->unsignedBigInteger('most_recent_order_id')->nullable();
            // $table->foreign('most_recent_order_id')
            //     ->references('id')->on('orders')
            //     ->onDelete('set null');
            // Instead, define the column without the constraint:
            $table->unsignedBigInteger('most_recent_order_id')->nullable();
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
