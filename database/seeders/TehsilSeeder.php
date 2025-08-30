<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TehsilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $path = database_path('seeders/sql/tehsil.sql');
        $sql = File::get($path);
        DB::unprepared($sql);
        $this->command->info('Tehsil seeded successfully!');
    }
}
