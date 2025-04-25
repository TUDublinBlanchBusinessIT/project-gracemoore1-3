<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $t) {
            if (! Schema::hasColumn('orders','user_id')) {
                $t->unsignedBigInteger('user_id')->nullable()->after('list_of_items');
                $t->foreign('user_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $t) {
            if (Schema::hasColumn('orders','user_id')) {
                $t->dropForeign(['user_id']);
                $t->dropColumn('user_id');
            }
        });
    }

    
}
