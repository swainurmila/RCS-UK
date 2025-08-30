<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
        ]); */

        $user = User::updateOrCreate(
            ['email' => 'arcs@gmail.com'],
            [
                'name' => 'Arcs',
                'mob_no' => '8965896589',
                'role_id' => 3,
                'password' => Hash::make('12345678')
            ]
        );
        $user->syncRoles([$user->role_id]);
        $user1 = User::updateOrCreate(
            ['email' => 'ado@gmail.com'],
            [
                'name' => 'ado',
                'mob_no' => '8965896589',
                'role_id' => 4,
                'password' => Hash::make('12345678')
            ]
        );
        $user1->syncRoles([$user1->role_id]);
        $user2 = User::updateOrCreate(
            ['email' => 'drcs@gmail.com'],
            [
                'name' => 'drcs',
                'mob_no' => '8965896589',
                'role_id' => 5,
                'password' => Hash::make('12345678')
            ]
        );
        $user2->syncRoles([$user2->role_id]);
        $user3 = User::updateOrCreate(
            ['email' => 'registrar@gmail.com'],
            [
                'name' => 'registrar',
                'mob_no' => '8965896589',
                'role_id' => 6,
                'password' => Hash::make('12345678')
            ]
        );
        $user3->syncRoles([$user3->role_id]);
        $user4 = User::updateOrCreate(
            ['email' => 'anil@gmail.com'],
            [
                'name' => 'Shri Anil Kumar Bharati',
                'role_id' => 8,
                'mob_no' => '8989898525',
                'password' => Hash::make('12345678')
            ]
        );
        $user4->syncRoles([$user4->role_id]);
        $user5 = User::updateOrCreate(
            ['email' => 'biswa@gmail.com'],
            [
                'name' => 'Shri Biswajit Mitra',
                'role_id' => 8,
                'mob_no' => '8989898526',
                'password' => Hash::make('12345678')
            ]
        );
        $user5->syncRoles([$user4->role_id]);

        $user6 = User::updateOrCreate(
            ['email' => 'jrcs@gmail.com'],
            [
                'name' => 'JRCS',
                'role_id' => 12,
                'mob_no' => '8989898526',
                'password' => Hash::make('12345678')
            ]
        );
        $user6->syncRoles([$user6->role_id]);

        $user7 = User::updateOrCreate(
            ['email' => 'additionalrcs@gmail.com'],
            [
                'name' => 'Additional RCS',
                'role_id' => 11,
                'mob_no' => '8989898526',
                'password' => Hash::make('12345678')
            ]
        );
        $user7->syncRoles([$user7->role_id]);

        $user8 = User::updateOrCreate(
            ['email' => 'adco@gmail.com'],
            [
                'name' => 'ADCO',
                'role_id' => 13,
                'mob_no' => '8989898526',
                'password' => Hash::make('12345678')
            ]
        );
        $user8->syncRoles([$user8->role_id]);

        $user9 = User::updateOrCreate(
            ['email' => 'supervisor@gmail.com'],
            [
                'name' => 'supervisor',
                'role_id' => 13,
                'mob_no' => '8989898898',
                'password' => Hash::make('12345678')
            ]
        );
        $user9->syncRoles([$user9->role_id]);

        // $user4 = User::updateOrCreate(
        //     ['email' => 'demouser@gmail.com'],
        //     [
        //         'role_id' => 7,
        //     ]
        // );
        // $user4->syncRoles([$user4->role_id]);
        $this->command->info('Users seeded successfully!');
    }
}