<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductFieldOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_field_options', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('product_field_id')->nullable()->unsigned()->comment('分野ID');
            $table->foreign('product_field_id')->references('id')->on('product_fields')->onDelete('cascade');
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
        Schema::dropIfExists('product_field_options');
    }
}
