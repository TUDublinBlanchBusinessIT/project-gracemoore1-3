<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEmployeeIdFromOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $t) {
        // if it exists, drop the FK + column
            if (Schema::hasColumn('orders','employee_id')) {
                $t->dropForeign(['employee_id']);
                $t->dropColumn('employee_id');
            }   
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $t) {
        // you can leave this empty or re-add if you like
        });
    }

}
