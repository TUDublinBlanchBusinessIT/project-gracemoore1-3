<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id(); // Primary Key: employee id
            $table->string('name');
            // This column holds the most recent customer (foreign key to customers.id)
            $table->unsignedBigInteger('last_customer_id')->nullable();
            $table->timestamps();

            // Foreign key constraint. When the referenced customer is deleted, set this to null.
            $table->foreign('last_customer_id')
                  ->references('id')->on('customers')
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
        Schema::dropIfExists('employees');
    }
}
