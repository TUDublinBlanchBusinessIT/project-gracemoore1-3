<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // 1) Drop the old FK on whatever column is pointing at employees.id
            $table->dropForeign(['user_id']/* or ['employee_id'] if you still have that column */);

            // 2) Drop that column entirely
            $table->dropColumn('user_id');

            // 3) Re-add it pointing at users.id instead
            $table->unsignedBigInteger('user_id')->nullable()->after('list_of_items');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // reverse: drop the new FK+column
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');

            // (optional) put back the old one against employees if you ever need it
            $table->unsignedBigInteger('user_id')->nullable()->after('list_of_items');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('employees')
                  ->nullOnDelete();
        });
    }
};
