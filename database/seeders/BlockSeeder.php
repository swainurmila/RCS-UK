<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BlockSeeder extends Seeder
{
    public function run()
    {
        $path = database_path('seeders/sql/blocks.sql');
        $sql = File::get($path);
        DB::unprepared($sql);
        $this->command->info('Blocks seeded successfully!');
    }
}
