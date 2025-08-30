<?php

namespace Database\Seeders;

// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\Hash;
use Database\Seeders\BlockSeeder;
use Database\Seeders\DistrictSeeder;
use Database\Seeders\StateSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BlockSeeder::class,
            DistrictSeeder::class,
            StateSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            DivisionSeeder::class,
            SocietySectorTypeSeeder::class,
            ComplaintTypeSeeder::class,
            DistrictWiseArcsSeeder::class
        ]);
        $this->command->info('All seeders seeded successfully!');
    }
}