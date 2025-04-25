<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReplaceEmployeeIdWithUserIdOnOrders extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // drop old employee_id if it exists
            if (Schema::hasColumn('orders','employee_id')) {
                $table->dropForeign(['employee_id']);
                $table->dropColumn('employee_id');
            }

            // add user_id
            if (! Schema::hasColumn('orders','user_id')) {
                $table->unsignedBigInteger('user_id')
                      ->nullable()
                      ->after('list_of_items');
                $table->foreign('user_id')
                      ->references('id')
                      ->on('users')
                      ->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders','user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }
            // we won’t re-add employee_id here
        });
    }
}

