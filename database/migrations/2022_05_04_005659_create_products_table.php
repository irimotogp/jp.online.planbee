<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\IntroducerType;
use App\Enums\ContractType;

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
            $table->enum('contract_type', ContractType::ALL_OPTIONS)->nullable()->commet('契約タイプ,購入コース');
            $table->enum('introducer_type', IntroducerType::ALL_OPTIONS)->nullable()->commet('タイプ');
            
            $table->bigInteger('product_field_id')->nullable()->unsigned()->comment('分野');
            $table->foreign('product_field_id')->references('id')->on('product_fields');
            
            $table->integer('initial_price')->default(0)->nullable()->comment('初期費用');
            $table->integer('month_price')->default(0)->nullable()->comment('月額料');

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
