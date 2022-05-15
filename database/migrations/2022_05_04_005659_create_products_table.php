<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\IntroducerType;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('code')->nullable()->comment('Code');
            $table->string('product_name')->nullable()->comment('商品名');
            $table->string('display_name')->nullable()->comment('表示名');
            $table->boolean('cashback')->default(0)->commet('キャッシュバック対象');
            $table->enum('introducer_type', IntroducerType::ALL_OPTIONS)->nullable()->commet('タイプ');
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
        Schema::dropIfExists('products');
    }
}
