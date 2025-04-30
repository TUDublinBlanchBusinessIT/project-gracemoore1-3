// database/migrations/xxxx_add_special_requests_to_carts_table.php
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecialRequestsToCartsTable extends Migration
{
    public function up()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->text('special_requests')->nullable();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->text('special_requests')->nullable();
        });
    }

    public function down()
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('special_requests');
        });
    }
}

