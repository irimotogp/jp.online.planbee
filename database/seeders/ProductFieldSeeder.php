<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('product_fields')->truncate();
        //
        $data = $this->data();
        \DB::table('product_fields')->insert($data);

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
    
    public function data() {
        return [
          [
            'name' => "ビーファインAQ",
          ],
          [
            'name' => "ビーファインIP",
          ],
          [
            'name' => "ビーファインIP2",
          ],
          [
            'name' => "ビーファインIP3",
          ],
          [
            'name' => "風呂用浄水器",
          ],
          [
            'name' => "スパッシュ",
          ],
          [
            'name' => "バビー",
          ],
          [
            'name' => "その他",
          ],
        ];
    }
}
