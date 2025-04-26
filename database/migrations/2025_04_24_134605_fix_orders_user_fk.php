<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // 1) drop the old FK
            $table->dropForeign('orders_employee_id_foreign');
            // 2) (optional) drop the old index
            $table->dropIndex('orders_employee_id_foreign');
            // 3) redefine user_id → users.id
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            // if you want the old employees FK back, you’d re-add it here…
        });
    }
};

