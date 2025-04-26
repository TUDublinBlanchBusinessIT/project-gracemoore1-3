<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // 1) Drop the old employee_id foreign key & column
            if (Schema::hasColumn('orders', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            // 2) Add the new user_id column
            if (! Schema::hasColumn('orders', 'user_id')) {
                $table->unsignedBigInteger('user_id')
                      ->nullable()
                      ->after('total_price');
                $table->foreign('user_id')
                      ->references('id')
                      ->on('users')
                      ->onDelete('set null');
            }
        });

        // 3) Drop the old employees table entirely
        if (Schema::hasTable('employees')) {
            Schema::drop('employees');
        }
    }

    public function down(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            // … you’d have to re-build whatever columns you had before …
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            // drop the new FK & column
            $table->dropForeign(['employee_id']);
            $table->dropColumn('employee_id');

            // restore the old employee_id
            $table->unsignedBigInteger('user_id')->nullable()->after('total_price');
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }
};
