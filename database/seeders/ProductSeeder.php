<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\IntroducerType;
use App\Enums\ContractType;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('products')->truncate();
        //
        $data = $this->data();
        \DB::table('products')->insert($data);

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
    
    public function data() {
        return [
          [
            'code' => 5,
            'product_name' => "エントリー（R）",
            'display_name' => "ビーファインR",
            'contract_type' => ContractType::NORMAL,
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 0,
            'product_field_id' => 1,
            'initial_price' => 16500,
            'month_price' => 11000,
          ],
          [
            'code' => 6,
            'product_name' => "ベーシック（SPASH!）",
            'display_name' => "SPASH!",
            'contract_type' => ContractType::NORMAL,
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
            'product_field_id' => 6,
            'initial_price' => 27500,
            'month_price' => 11000,
          ],
          [
            'code' => 13,
            'product_name' => "エクセルEX",
            'display_name' => "エクセルEX",
            'contract_type' => ContractType::NORMAL,
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 0,
            'product_field_id' => 2,
            'initial_price' => 13156,
            'month_price' => 6578,
          ],
          [
            'code' => 21,
            'product_name' => "プレミアム（R3）",
            'display_name' => "ビーファインR3",
            'contract_type' => ContractType::NORMAL,
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
            'product_field_id' => 3,
            'initial_price' => 55000,
            'month_price' => 11000,
          ],
          [
            'code' => 22,
            'product_name' => "プレミアム（BUBEE）",
            'display_name' => "BUBEE",
            'contract_type' => ContractType::NORMAL,
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 0,
            'product_field_id' => 7,
            'initial_price' => 55000,
            'month_price' => 11000,
          ],
          [
            'code' => 23,
            'product_name' => "プレミアム（R3一括CUS）",
            'display_name' => "ビーファインR3（一括）",
            'contract_type' => ContractType::NORMAL,
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
            'product_field_id' => 2,
            'initial_price' => 382800,
            'month_price' => 11000,
          ],
          [
            'code' => 24,
            'product_name' => "プレミアム（BUBEE一括CUS）",
            'display_name' => "BUBEE（一括）",
            'contract_type' => ContractType::NORMAL,
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 0,
            'product_field_id' => 7,
            'initial_price' => 382800,
            'month_price' => 11000,
          ],
          [
            'code' => 27,
            'product_name' => "ベーシック（RS一括CUS）",
            'display_name' => "ビーファインRS（一括）",
            'contract_type' => ContractType::BULK,
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
            'product_field_id' => 1,
            'initial_price' => 371800,
            'month_price' => 11000,
          ],
          [
            'code' => 28,
            'product_name' => "ベーシック（SPASH一括CUS）",
            'display_name' => "SPASH!（一括）",
            'contract_type' => ContractType::BULK,
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 0,
            'product_field_id' => 6,
            'initial_price' => 371800,
            'month_price' => 11000,
          ],
          [
            'code' => 29,
            'product_name' => "エントリー（R一括CUS）",
            'display_name' => "ビーファインR（一括）",
            'contract_type' => ContractType::BULK,
            'introducer_type' => IntroducerType::ALL,
            'cashback' => 0,
            'product_field_id' => 1,
            'initial_price' => 360800,
            'month_price' => 11000,
          ],
          [
            'code' => 34,
            'product_name' => "ベーシック（RS）",
            'display_name' => "ビーファインRS",
            'contract_type' => ContractType::BULK,
            'introducer_type' => IntroducerType::ALL,
            'cashback' => 1,
            'product_field_id' => 1,
            'initial_price' => 27500,
            'month_price' => 11000,
          ],
          [
            'code' => 1000,
            'product_name' => "（取）プレミアム（R3）",
            'display_name' => "ビーファインR3",
            'contract_type' => ContractType::NORMAL,
            'introducer_type' => IntroducerType::ALL,
            'cashback' => 0,
            'product_field_id' => 3,
            'initial_price' => 165000,
            'month_price' => 11000,
          ],
          [
            'code' => 1005,
            'product_name' => "（取・括）プレミアム（R3）",
            'display_name' => "ビーファインR3（一括）",
            'contract_type' => ContractType::NORMAL,
            'introducer_type' => IntroducerType::ALL,
            'cashback' => 1,
            'product_field_id' => 3,
            'initial_price' => 547800,
            'month_price' => 11000,
          ],
          [
            'code' => 1010,
            'product_name' => "（取）プレミアム（BUBEE）",
            'display_name' => "BUBEE",
            'contract_type' => ContractType::NORMAL,
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 0,
            'product_field_id' => 7,
            'initial_price' => 165000,
            'month_price' => 11000,
          ],
          [
            'code' => 1015,
            'product_name' => "（取・括）プレミアム（BUBEE）",
            'display_name' => "BUBEE（一括）",
            'contract_type' => ContractType::NORMAL,
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 1,
            'product_field_id' => 7,
            'initial_price' => 547800,
            'month_price' => 11000,
          ],
          [
            'code' => 1200,
            'product_name' => "（取）ベーシック（RS）",
            'display_name' => "ビーファインRS",
            'contract_type' => ContractType::NORMAL,
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 0,
            'product_field_id' => 1,
            'initial_price' => 137500,
            'month_price' => 11000,
          ],
          [
            'code' => 1205,
            'product_name' => "（取・括）ベーシック（RS）",
            'display_name' => "ビーファインRS（一括）",
            'contract_type' => ContractType::NORMAL,
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 1,
            'product_field_id' => 1,
            'initial_price' => 520300,
            'month_price' => 11000,
          ],
          [
            'code' => 1210,
            'product_name' => "（取）ベーシック（SPASH!）",
            'display_name' => "SPASH!",
            'contract_type' => ContractType::BULK,
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 0,
            'product_field_id' => 6,
            'initial_price' => 137500,
            'month_price' => 11000,
          ],
          [
            'code' => 1215,
            'product_name' => "（取・括）ベーシック（SPASH!）",
            'display_name' => "SPASH!（一括）",
            'contract_type' => ContractType::BULK,
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 1,
            'product_field_id' => 6,
            'initial_price' => 520300,
            'month_price' => 11000,
          ],
          [
            'code' => 1300,
            'product_name' => "（取）エントリー（R）",
            'display_name' => "ビーファインR",
            'contract_type' => ContractType::BULK,
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 0,
            'product_field_id' => 1,
            'initial_price' => 126500,
            'month_price' => 11000,
          ],
          [
            'code' => 1305,
            'product_name' => "（取・括）エントリー（R）",
            'display_name' => "ビーファインR（一括）",
            'contract_type' => ContractType::BULK,
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 0,
            'product_field_id' => 1,
            'initial_price' => 509300,
            'month_price' => 11000,
          ],
        ];
    }
}
