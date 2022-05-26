<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('product_options')->truncate();
        //
        $data = $this->data();
        \DB::table('product_options')->insert($data);

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
    
    public function data() {
        return [
          [
            'name' => "フレキロング（800mm）",
            'price' => 2750,
          ],
          [
            'name' => "ローレットタケノコ",
            'price' => 0,
          ],
          [
            'name' => "ビス止めアダプター",
            'price' => 0,
          ],
          [
            'name' => "HG浄水フィルターに交換",
            'price' => 3300,
          ],
          [
            'name' => "給水ホースロング",
            'price' => 2200,
          ],
          [
            'name' => "シャワーホースロング",
            'price' => 2200,
          ],
        ];
    }
}
