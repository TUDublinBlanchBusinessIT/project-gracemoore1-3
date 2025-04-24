<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // 1) Add the column
            $table->unsignedBigInteger('user_id')->nullable()->after('total_price');
            // 2) Make it point at users.id
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // 1) drop the foreign key
            $table->dropForeign(['user_id']);
            // 2) drop the column
            $table->dropColumn('user_id');
        });
    }
};

