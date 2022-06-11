<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\SexType;
use App\Enums\ContractType;
use App\Enums\DepositType;
use App\Enums\ShippingAddressType;
use App\Enums\InitialPaymentType;
use App\Enums\MonthlyPaymentType;
use App\Enums\PaymentNumberType;
use App\Enums\CardCompanyType;
use App\Enums\DesireContacType;
use App\Enums\DesireDateTimeType;
use App\Enums\BasicFeeType;
use App\Enums\CommercialPrivacyType;



class CreateAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agencies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('introducer_id')->nullable()->unsigned()->comment('紹介者');
            $table->foreign('introducer_id')->references('id')->on('introducers');

            $table->enum('sex_type', SexType::ALL_OPTIONS)->nullable()->commet('性別');

            $table->string('kanji_sei')->nullable()->commet('姓');
            $table->string('kanji_mei')->nullable()->commet('名');
            $table->string('kata_sei')->nullable()->commet('ｾｲ');
            $table->string('kata_mei')->nullable()->commet('ﾒｲ');

            $table->string('corp_kanji')->nullable()->commet('法人名');
            $table->string('corp_kata')->nullable()->commet('ﾎｳｼﾞﾝﾒｲ');
            $table->string('rep_kanji_sei')->nullable()->commet('代表者姓');
            $table->string('rep_kanji_mei')->nullable()->commet('代表者名');
            $table->string('rep_kata_sei')->nullable()->commet('ﾀﾞｲﾋｮｳｼｬｾｲ');
            $table->string('rep_kata_mei')->nullable()->commet('ﾀﾞｲﾋｮｳｼｬﾒｲ');

            $table->date('birthday')->nullable()->commet('生年月日');
            $table->string('zip1')->nullable()->commet('郵便番号');
            $table->string('pref1')->nullable()->commet('都道府県');
            $table->string('city1')->nullable()->commet('住所１（番地まで）');
            $table->string('addr1')->nullable()->commet('住所２（マンション名・号室）');
            
            $table->string('home_phone')->nullable()->commet('自宅電話番号');
            $table->string('fax')->nullable()->commet('FAX番号');
            $table->string('mobile_phone')->nullable()->commet('携帯電話');
            $table->string('mobile_phone2')->nullable()->commet('携帯電話（予備）');
            $table->string('sinsei_email')->nullable()->commet('メールアドレス');
            $table->string('phone_email')->nullable()->commet('メールアドレス（予備）');
            $table->string('work_place_name')->nullable()->commet('勤務先名');
            $table->string('work_place_phone')->nullable()->commet('勤務先電話番号');
            
            $table->enum('contract_type', ContractType::ALL_OPTIONS)->nullable()->commet('契約タイプ');

            $table->string('syoukai_id')->nullable()->commet('紹介取次店ID');
            $table->string('syoukai_name')->nullable()->commet('紹介取次店名');
            $table->string('eva_id')->nullable()->commet('エバンジェリストID');
            $table->string('eva_name')->nullable()->commet('エバンジェリスト名');

            $table->enum('shipping_address_type', ShippingAddressType::ALL_OPTIONS)->nullable()->commet('配送先指定');

            $table->string('zip2')->nullable()->commet('配送先-郵便番号');
            $table->string('pref2')->nullable()->commet('配送先-都道府県');
            $table->string('city2')->nullable()->commet('配送先-住所１');
            $table->string('addr2')->nullable()->commet('配送先-住所２');
            
            $table->string('receiver_name')->nullable()->commet('宛名');
            $table->string('receiver_phone')->nullable()->commet('宛先電話番号');

            $table->enum('initial_payment_type', InitialPaymentType::ALL_OPTIONS)->nullable()->commet('初期費用支払方法');
            $table->enum('payment_number_type', PaymentNumberType::ALL_OPTIONS)->nullable()->commet('支払い回数');
            $table->enum('card_company_type', CardCompanyType::ALL_OPTIONS)->nullable()->commet('カード会社');
            $table->string('card_number')->nullable()->commet('カード番号');
            $table->string('card_name')->nullable()->commet('カード名義');
            $table->string('expiration_date')->nullable()->commet('有効期限');
            
            $table->enum('monthly_payment_type', MonthlyPaymentType::ALL_OPTIONS)->nullable()->commet('月額料支払方法');
            
            $table->bigInteger('product_id')->nullable()->unsigned()->comment('契約商品');
            $table->foreign('product_id')->references('id')->on('products');

            $table->string('bank_name')->nullable()->commet('銀行名');
            $table->string('bank_code')->nullable()->commet('銀行コード');
            $table->string('branch_name')->nullable()->commet('支店名');
            $table->string('branch_code')->nullable()->commet('支店コード');
            
            $table->bigInteger('deposit_id')->nullable()->unsigned()->comment('預金種目');
            $table->foreign('deposit_id')->references('id')->on('deposits');

            $table->string('account_number')->nullable()->commet('口座番号');
            $table->string('account_name')->nullable()->commet('口座名義（ｶﾅ）');
            $table->string('identity_doc')->nullable()->commet('本人確認書類');
            $table->string('identity_doc2')->nullable()->commet('本人確認書類（予備）');
            
            $table->integer('desire_month')->nullable()->commet('希望登録月');
            $table->enum('desire_contact_type', DesireContacType::ALL_OPTIONS)->nullable()->commet('本人確認の希望連絡先');
            $table->enum('desire_datetime_type', DesireDateTimeType::ALL_OPTIONS)->nullable()->commet('希望日時');
            $table->string('desire_date')->nullable()->commet('希望日');
            $table->string('desire_start_h')->nullable()->commet('希望時');
            $table->string('desire_start_m')->nullable()->commet('希望分');
            $table->string('desire_end_h')->nullable()->commet('希望時');
            $table->string('desire_end_m')->nullable()->commet('希望分');

            $table->enum('basic_fee_type', BasicFeeType::ALL_OPTIONS)->nullable()->commet('基本取付工賃');
            
            $table->string('initial_price')->nullable()->nullable()->comment('初期費用合計金額');
            $table->string('month_price')->nullable()->nullable()->comment('月額料');

            $table->enum('commercial_privacy_type', CommercialPrivacyType::ALL_OPTIONS)->nullable()->commet('基本取付工賃');
            
            $table->text('note')->nullable()->commet('備考（通信欄）');
            
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
        Schema::dropIfExists('agencies');
    }
}
