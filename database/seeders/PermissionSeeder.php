<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'registration-of-co-operative' => '1',
            'amendment-of-by-laws' => '2',
            'annual-return-filling' => '3',
            'assets-management-system' => '4',
            'settlement-of-disputes' => '5',
            'audit' => '6',
            'inspection-of-records' => '7',
            'liquidation' => '8',
            'complaints' => '9',
            'election' => '10'
        ];

        $permissions = [

            'society-registration' => '1',
            'society-registration-show' => '1',
            'society-registration-add' => '1',
            'society-registration-edit' => '1',
            'society-registration-delete' => '1',

            'registration-status' => '1',
            'registration-status-show' => '1',
            'registration-status-add' => '1',
            'registration-status-edit' => '1',
            'registration-status-delete' => '1',

            'society-member' => '1',
            'society-member-show' => '1',
            'society-member-add' => '1',
            'society-member-edit' => '1',
            'society-member-delete' => '1',

            'roles' => '1',
            'roles-show' => '1',
            'roles-add' => '1',
            'roles-edit' => '1',
            'roles-delete' => '1',

        ];


        foreach ($permissions as $key => $permission) {
            $model = Permission::whereName($key);
            if ($model->count() > 0) {
                $newPerm = Permission::whereName($key)->update(['module_id' => $permission]);
            } else {
                if (!empty($permissions) && !empty($key)) {
                    Permission::create(['module_id' => $permission, 'name' => $key]);
                }
            }
        }



        $role = Role::updateOrCreate(['name' => "superadmin"]);

        $permissions = Permission::pluck('id', 'id')->all();
        $role->syncPermissions($permissions);
        $user = User::updateOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'mob_no' => '1234567890',
                'role_id' => $role->id,
                'password' => Hash::make('12345678')
            ]
        );
        $user->assignRole([$role->id]);
        $this->command->info('Permissions seeded successfully for all modules!');
    }
}
