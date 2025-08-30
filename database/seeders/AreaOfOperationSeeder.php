<?php

namespace Database\Seeders;
use App\Models\AreaOfOperation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaOfOperationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $areas = [
            ['name' => 'State'],
            ['name' => 'Division'],
            ['name' => 'District'],
            ['name' => 'Sub-division'],
            ['name' => 'Block'],
            ['name' => 'Panchayat'],
        ];

        foreach ($areas as $area) {
            AreaOfOperation::updateOrCreate(
                ['name' => $area['name']],  
                $area  
            );
        }
        $this->command->info('Area of operation data seeded successfully!');
    }
}
