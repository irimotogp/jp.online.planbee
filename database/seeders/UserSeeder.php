<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Enums\UserRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('users')->truncate();

        \DB::table('users')->insert([
            [
                'name' => "Super管理者",
                'email'=> "admin@gmail.com",
                'password'=>\Hash::make('qweqweqwe'),
                'created_at'     => Carbon::now()->subWeek(1),
                'updated_at'     => Carbon::now()->subWeek(1),
            ]
        ]);

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
