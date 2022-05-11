<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\SexType;
use App\Enums\ContractType;
use App\Enums\DepositType;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('introducer_id')->nullable()->unsigned()->comment('紹介者');
            $table->foreign('introducer_id')->references('id')->on('introducers');

            $table->string('kanji_sei')->nullable()->commet('姓');
            $table->string('kanji_mei')->nullable()->commet('名');
            $table->string('kata_sei')->nullable()->commet('ｾｲ');
            $table->string('kata_mei')->nullable()->commet('ﾒｲ');

            $table->enum('sex_type', SexType::ALL_OPTIONS)->nullable()->commet('性別');
            
            $table->date('birthday')->nullable()->commet('生年月日');

            $table->string('zip1')->nullable()->commet('郵便番号');
            $table->string('pref1')->nullable()->commet('都道府県');
            $table->string('city1')->nullable()->commet('住所１（番地まで）');
            $table->string('addr1')->nullable()->commet('住所２（マンション名・号室）');
            
            $table->string('home_phone')->nullable()->commet('自宅電話番号');
            $table->string('fax')->nullable()->commet('FAX番号');
            $table->string('mobile_phone')->nullable()->commet('携帯電話');
            $table->string('mobile_phone2')->nullable()->commet('携帯電話（予備）');
            $table->string('pc_email')->nullable()->commet('PCメール');
            $table->string('phone_email')->nullable()->commet('携帯メール');
            $table->string('work_place_name')->nullable()->commet('勤務先名');
            
            $table->bigInteger('shipping_address_id')->nullable()->unsigned()->comment('配送先指定');
            $table->foreign('shipping_address_id')->references('id')->on('shipping_addresses');

            $table->string('zip2')->nullable()->commet('配送先-郵便番号');
            $table->string('pref2')->nullable()->commet('配送先-都道府県');
            $table->string('city2')->nullable()->commet('配送先-住所１');
            $table->string('addr2')->nullable()->commet('配送先-住所２');
            
            $table->string('receiver_name')->nullable()->commet('宛名');
            $table->string('receiver_phone')->nullable()->commet('宛先電話番号');
            $table->string('syoukai_id')->nullable()->commet('紹介取次店ID');
            $table->string('syoukai_name')->nullable()->commet('紹介取次店名');
            $table->string('eva_id')->nullable()->commet('エバンジェリストID');
            $table->string('eva_name')->nullable()->commet('エバンジェリスト名');

            $table->enum('contract_type', ContractType::ALL_OPTIONS)->nullable()->commet('契約タイプ');
            
            $table->bigInteger('product_id')->nullable()->unsigned()->comment('契約商品');
            $table->foreign('product_id')->references('id')->on('products');

            $table->string('bank_name')->nullable()->commet('銀行名');
            $table->string('bank_code')->nullable()->commet('銀行コード');
            $table->string('branch_name')->nullable()->commet('支店名');
            $table->string('branch_code')->nullable()->commet('支店コード');
            
            $table->bigInteger('deposit_id')->nullable()->unsigned()->comment('預金種目');
            $table->foreign('deposit_id')->references('id')->on('deposits');

            $table->string('account_number')->nullable()->commet('口座番号');
            $table->string('identity_doc')->nullable()->commet('本人確認書類');
            $table->string('identity_doc2')->nullable()->commet('本人確認書類（予備）');
            
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
        Schema::dropIfExists('customers');
    }
}
