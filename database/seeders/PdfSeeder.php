<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\IntroducerType;

class PdfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        \DB::table('pdfs')->truncate();

        \DB::table('pdfs')->insert([
            [
                'introducer_type' => IntroducerType::AGENCY,
                'file' => null,
            ],
            [
                'introducer_type' => IntroducerType::CUSTOMER,
                'file' => null,
            ]
        ]);

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
