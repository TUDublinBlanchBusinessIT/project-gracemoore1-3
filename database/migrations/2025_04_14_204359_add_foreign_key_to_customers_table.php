<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeyToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        // Ensure that the orders table already exists before executing this migration.
        Schema::table('customers', function (Blueprint $table) {
            // Add the foreign key constraint
            $table->foreign('most_recent_order_id')
                  ->references('id')->on('orders')
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
        Schema::table('customers', function (Blueprint $table) {
            // Drop the foreign key if needed during rollback
            $table->dropForeign(['most_recent_order_id']);
        });
    }
}
