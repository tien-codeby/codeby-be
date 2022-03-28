<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSplitRatiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('split_ratios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dev_project_id')->nullable();
            $table->double('price', 15, 2)->nullable();
            $table->double('price_dev_recieve', 15, 2)->nullable();
            $table->double('price_admin_recieve', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('split_ratios');
    }
}
