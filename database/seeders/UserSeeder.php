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

        for ($i = 1; $i <= 3; $i ++) {
            \DB::table('users')->insert([
                [
                    'id'   => $i,
                    'name' => "店舗代表者" . $i,
                    'email'=> "store".$i."@gmail.com",
                    'password'=>\Hash::make('qweqweqwe'),
                    'created_at'     => Carbon::now()->subWeek(1),
                    'updated_at'     => Carbon::now()->subWeek(1),
                ]
            ]);
        }
        

        for ($i = 1; $i <= 6; $i ++) {
            \DB::table('users')->insert([
                [
                    'id'   => $i + 3,
                    'name' => "ユーザー" . $i,
                    'email'=> "user".$i."@gmail.com",
                    'password'=>\Hash::make('qweqweqwe'),
                    'created_at'     => Carbon::now()->subWeek(1),
                    'updated_at'     => Carbon::now()->subWeek(1),
                ]
            ]);
        }

        \DB::table('users')->insert([
            [
                'id'   => 10,
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
