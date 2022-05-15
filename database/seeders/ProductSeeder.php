<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\IntroducerType;

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
            'code' => 1000,
            'product_name' => "（取）プレミアム（R3）",
            'display_name' => "ビーファインR3",
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 1,
          ],
          [
            'code' => 1005,
            'product_name' => "（取・括）プレミアム（R3）",
            'display_name' => "ビーファインR3（一括）",
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 1,
          ],
          [
            'code' => 1010,
            'product_name' => "（取）プレミアム（BUBEE）",
            'display_name' => "BUBEE",
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 1,
          ],
          [
            'code' => 1015,
            'product_name' => "（取・括）プレミアム（BUBEE）",
            'display_name' => "BUBEE（一括）",
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 1,
          ],
          [
            'code' => 1200,
            'product_name' => "（取）ベーシック（RS）",
            'display_name' => "ビーファインRS",
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 1,
          ],
          [
            'code' => 1205,
            'product_name' => "（取・括）ベーシック（RS）",
            'display_name' => "ビーファインRS（一括）",
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 1,
          ],
          [
            'code' => 1210,
            'product_name' => "（取）ベーシック（SPASH!）",
            'display_name' => "SPASH!",
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 1,
          ],
          [
            'code' => 1215,
            'product_name' => "（取・括）ベーシック（SPASH!）",
            'display_name' => "SPASH!（一括）",
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 1,
          ],
          [
            'code' => 1300,
            'product_name' => "（取）エントリー（R）",
            'display_name' => "ビーファインR",
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 1,
          ],
          [
            'code' => 1305,
            'product_name' => "（取・括）エントリー（R）",
            'display_name' => "ビーファインR（一括）",
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 1,
          ],
          [
            'code' => 1310,
            'product_name' => "（取）エクセルEX",
            'display_name' => "エクセルEX",
            'introducer_type' => IntroducerType::AGENCY,
            'cashback' => 1,
          ],
          [
            'code' => 5,
            'product_name' => "エントリー（R）",
            'display_name' => "ビーファインR",
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
          ],
          [
            'code' => 6,
            'product_name' => "ベーシック（SPASH!）",
            'display_name' => "SPASH!",
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
          ],
          [
            'code' => 13,
            'product_name' => "エクセルEX",
            'display_name' => "エクセルEX",
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
          ],
          [
            'code' => 21,
            'product_name' => "プレミアム（R3）",
            'display_name' => "ビーファインR3",
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
          ],
          [
            'code' => 22,
            'product_name' => "プレミアム（BUBEE）",
            'display_name' => "BUBEE",
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
          ],
          [
            'code' => 23,
            'product_name' => "プレミアム（R3一括CUS）",
            'display_name' => "ビーファインR3（一括）",
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
          ],
          [
            'code' => 24,
            'product_name' => "プレミアム（BUBEE一括CUS）",
            'display_name' => "BUBEE（一括）",
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
          ],
          [
            'code' => 25,
            'product_name' => "プレミアム（RS一括CUS）",
            'display_name' => "ビーファインRS（一括）",
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
          ],
          [
            'code' => 26,
            'product_name' => "プレミアム（SPASH一括CUS）",
            'display_name' => "SPASH!（一括）",
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
          ],
          [
            'code' => 27,
            'product_name' => "ベーシック（RS一括CUS）",
            'display_name' => "ビーファインRS（一括）",
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
          ],
          [
            'code' => 28,
            'product_name' => "ベーシック（SPASH一括CUS）",
            'display_name' => "SPASH!（一括）",
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 1,
          ],
          [
            'code' => 29,
            'product_name' => "エントリー（R一括CUS）",
            'display_name' => "ビーファインR（一括）",
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 0,
          ],
          [
            'code' => 34,
            'product_name' => "ベーシック（RS）",
            'display_name' => "ビーファインRS",
            'introducer_type' => IntroducerType::CUSTOMER,
            'cashback' => 0,
          ],
        ];
    }
}
