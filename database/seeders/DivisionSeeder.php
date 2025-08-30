<?php

namespace Database\Seeders;
use App\Models\Divisions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisions = [
            ['state_id'=>1,'name' => 'Garhwal'],
            ['state_id'=>1,'name' => 'Kumaon']
        ];

        foreach ($divisions as $type) {
            Divisions::updateOrCreate(
                ['name' => $type['name']],  
                $type  
            );
        }
        $this->command->info('Division data seeded successfully!');
    }
}
