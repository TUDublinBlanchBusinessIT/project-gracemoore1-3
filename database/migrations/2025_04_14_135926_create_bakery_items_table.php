<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBakeryItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('bakery_items', function (Blueprint $table) {
            $table->id(); // Primary key: item id
            $table->string('name');
            $table->decimal('price', 8, 2);
            $table->string('image')->nullable(); // Path or URL to the image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('bakery_items');
    }
}


