<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductFieldOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('product_field_options')->truncate();
        //
        $data = $this->data();
        \DB::table('product_field_options')->insert($data);

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
    
    public function data() {
        return [
          [
            'product_field_id' => 1,
            'product_option_id' => 1,
          ],
          [
            'product_field_id' => 1,
            'product_option_id' => 2,
          ],
          [
            'product_field_id' => 2,
            'product_option_id' => 1,
          ],
          [
            'product_field_id' => 2,
            'product_option_id' => 2,
          ],
          [
            'product_field_id' => 2,
            'product_option_id' => 3,
          ],
          [
            'product_field_id' => 2,
            'product_option_id' => 4,
          ],
          [
            'product_field_id' => 3,
            'product_option_id' => 1,
          ],
          [
            'product_field_id' => 3,
            'product_option_id' => 2
          ],
          [
            'product_field_id' => 3,
            'product_option_id' => 3,
          ],
          [
            'product_field_id' => 4,
            'product_option_id' => 1,
          ],
          [
            'product_field_id' => 4,
            'product_option_id' => 2
          ],
          [
            'product_field_id' => 4,
            'product_option_id' => 3,
          ],
          [
            'product_field_id' => 5,
            'product_option_id' => 5,
          ],
          [
            'product_field_id' => 5,
            'product_option_id' => 6
          ],
        ];
    }
}
