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
                'file' => config('filesystems.file_upload_path') . '/none.pdf',
            ],
            [
                'introducer_type' => IntroducerType::CUSTOMER,
                'file' => config('filesystems.file_upload_path') . '/none.pdf',
            ]
        ]);

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
