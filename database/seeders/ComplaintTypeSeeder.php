<?php

namespace Database\Seeders;

use App\Models\Complaint_type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComplaintTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $complaint_type = [
            ['name' => 'Societies'],
            ['name' => 'Banks'],
            ['name' => 'Employee/Staff Issues'],
            ['name' => 'Departmental Services'],
            ['name' => 'Others'],
        ];

        foreach ($complaint_type as $type) {
            Complaint_type::updateOrCreate(
                ['name' => $type['name']],
                $type
            );
        }
        $this->command->info('Complaint Type data seeded successfully!');
    }
}