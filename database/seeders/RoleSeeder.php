<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => "superadmin",
                'display_name' => "Super Admin",
                'description' => "System Admistrator",
                'guard_name' => "web",
            ],
            [
                'name' => "admin",
                'display_name' => "Admin",
                'description' => "Admin",
                'guard_name' => "web",
            ],
            [
                'name' => "arcs",
                'display_name' => "Assistant Registrar of Cooperative Societies",
                'description' => "Initial scrutiny and verification, distsrict wise user",
                'guard_name' => "web",
            ],
            [
                'name' => "ado",
                'display_name' => "District Agricultural Development Officer",
                'description' => "Sectoral verification, block wise user",
                'guard_name' => "web",
            ],
            [
                'name' => "drcs",
                'display_name' => "Deputy Registrar of Cooperative Societies",
                'description' => "Final approval for Primary and Central, district or division wise user",
                'guard_name' => "web",
            ],
            [
                'name' => "registrar",
                'display_name' => "Registrar of Cooperative Societies",
                'description' => "Final authority for APEX societies.all over state",
                'guard_name' => "web",
            ],
            [
                'name' => "society",
                'display_name' => "Society",
                'description' => "society user / applicant",
                'guard_name' => "web",
            ],
            [
                'name' => "auditor",
                'display_name' => "Auditor",
                'description' => "Audit the Application",
                'guard_name' => "web",
            ],
            [
                'name' => "ldr",
                'display_name' => "Liquidator",
                'description' => "Liquidator authority",
                'guard_name' => "web",
            ],
            [
                'name' => "inspector",
                'display_name' => "Inspector",
                'description' => "Inspection authority for inspection module",
                'guard_name' => "web",
            ],
            [
                'name' => "additionalrcs",
                'display_name' => "Additional RCS",
                'description' => "Additional Registrar of Cooperative Societies",
                'guard_name' => "web",
            ],
            [
                'name' => "jrcs",
                'display_name' => "Joint Registrar of Cooperative Societies",
                'description' => "Joint Registrar of Cooperative Societies",
                'guard_name' => "web",
            ],
            [
                'name' => "adco",
                'display_name' => "Assistant District Cooperative Officer",
                'description' => "Assistant District Cooperative Officer",
                'guard_name' => "web",
            ],
            [
                'name' => "supervisor",
                'display_name' => "Block Supervisor",
                'description' => "Block Supervisor",
                'guard_name' => "web",
            ],

        ];

        // Role::truncate();
        foreach ($roles as $key => $value) {
            $role = Role::updateOrCreate(
                [
                    'name' => $value['name'],
                    'display_name' => $value['display_name'],
                    'description' => $value['description'],
                    'guard_name' => $value['guard_name'],
                ],
            );
        }

        $this->command->info('Roles seeded successfully!');
    }
}