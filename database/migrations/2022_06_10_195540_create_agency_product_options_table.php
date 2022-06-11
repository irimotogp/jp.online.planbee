<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgencyProductOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agency_product_options', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('agency_id')->nullable()->unsigned();
            $table->foreign('agency_id')->references('id')->on('agencies')->onDelete('cascade');
            $table->bigInteger('product_option_id')->nullable()->unsigned()->comment('オプションID');
            $table->foreign('product_option_id')->references('id')->on('product_options')->onDelete('cascade');
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
        Schema::dropIfExists('agency_product_options');
    }
}
