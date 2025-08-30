<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DistrictWiseArcsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { {
            
            $districts = District::all();
            foreach ($districts as $val) {
                // Create or update ARC user for the district
                $user = User::updateOrCreate(
                    ['email' => strtolower(str_replace(' ', '', $val->name)) . '@arcs.com'],
                    [
                        'name' => $val->name . ' ARCS',
                        'password' => bcrypt('12345678'),
                        'district_id' => $val->id,
                        'role_id' => 3
                    ]
                );

                // Assign ARC role by ID (3)
                $user->syncRoles([3]);
            }
        }
        $this->command->info('DistrictWise ARCS seeded successfully!');
    }
}