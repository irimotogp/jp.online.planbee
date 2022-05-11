<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DepositSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('deposits')->truncate();
        //
        $data = $this->data();
        \DB::table('deposits')->insert($data);

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
    
    public function data() {
        return [
          [ 'name' => '普通預金' ],
          [ 'name' => '当座預金' ],
          [ 'name' => '貯蓄預金' ],
          [ 'name' => '他' ],
        ];
    }
}
