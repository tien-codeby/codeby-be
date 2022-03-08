<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeFloatToStringCartAndDevProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dev_projects', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('sale_price');
        });
        Schema::table('carts', function (Blueprint $table) {
            $table->dropColumn('total_price');
        });
    // recreate
        Schema::table('dev_projects', function (Blueprint $table) {
            $table->string('price')->nullable();
            $table->string('sale_price')->nullable();
        });
        Schema::table('carts', function (Blueprint $table) {
            $table->string('total_price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('string_cart_and_dev_project', function (Blueprint $table) {
            //
        });
    }
}
