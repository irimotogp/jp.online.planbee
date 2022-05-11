<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShippingAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('shipping_addresses')->truncate();
        //
        $data = $this->data();
        \DB::table('shipping_addresses')->insert($data);

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
    
    public function data() {
        return [
          [ 'name' => '現住所' ],
          [ 'name' => '発送先別' ],
          [ 'name' => '商品のみ別' ],
          [ 'name' => '書類のみ別' ],
        ];
    }
}
