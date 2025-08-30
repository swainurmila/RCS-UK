<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('districts')->insert([
            ["state_id" => 1,"division_id"=>1,'name' => 'Dehradun'],
            ["state_id" => 1,"division_id"=>1,'name' => 'Haridwar'],
            ["state_id" => 1,"division_id"=>1,'name' => 'Chamoli'],
            ["state_id" => 1,"division_id"=>1,'name' => 'Tehri'],
            ["state_id" => 1,"division_id"=>1,'name' => 'Rudraprayg'],
            ["state_id" => 1,"division_id"=>1,'name' => 'Uttarkashi'],
            ["state_id" => 1,"division_id"=>1,'name' => 'Pauri Garhwal'],
            ["state_id" => 1,"division_id"=>2,'name' => 'Almora'],
            ["state_id" => 1,"division_id"=>2,'name' => 'Nainital'],
            ["state_id" => 1,"division_id"=>2,'name' => 'Pithoragarh'],
            ["state_id" => 1,"division_id"=>2,'name' => 'UdhamSinghNagar'],
            ["state_id" => 1,"division_id"=>2,'name' => 'Bageshwar'],
            ["state_id" => 1,"division_id"=>2,'name' => 'Champawt'],
        ]);
        $this->command->info('District seeded successfully!');
    }
}
