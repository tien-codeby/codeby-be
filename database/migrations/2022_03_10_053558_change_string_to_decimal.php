<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeStringToDecimal extends Migration
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
            $table->double('price', 15, 2)->nullable();
            $table->double('sale_price', 15, 2)->nullable();
        });
        Schema::table('carts', function (Blueprint $table) {
            $table->double('total_price', 15, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('decimal', function (Blueprint $table) {
            //
        });
    }
}
