<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveEmployeeForeignKeyFromOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
        // Drop the old constraint (use exact name from SHOW CREATE TABLE)
            $table->dropForeign('orders_employee_id_foreign');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
        // For rollback - recreate the old constraint
            $table->foreign('user_id', 'orders_employee_id_foreign')
                ->references('id')
                ->on('employees')
                ->onDelete('set null');
        });
    }
  
}
