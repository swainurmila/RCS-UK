<?php

use Illuminate\Foundation\Console\ClosureCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    /** @var ClosureCommand $this */
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('setup:database', function () {
    $migrate = Artisan::call('migrate');
    $roleseeder = Artisan::call('db:seed --class="RoleSeeder"');
    // $permissioseeder = Artisan::call('db:seed --class="PermissionTableSeeder"');
    if ($migrate) {
        $this->info("Migrating completed successfully. Data Seeding please wait.........................");
    } else {
        $this->info("Nothing to migrate..............................Done");
    }
    if ($roleseeder) {
        $this->info("Role Seeder completed successfully. Permission Seeding please wait.........................");
    } else {
        $this->info("Nothing to seed in Role Seeder............................Done.");
    }
    // if($permissioseeder)
    // {
    //     $this->info("Permission Seeder completed successfully.................................. Done");
    // }else{
    //     $this->info("Nothing to seed in Permission Seeder.................................. Done");
    // }
    $this->info("Setup database completed successfully.................................................Done");
})->purpose('Migrate all the related tables and master data');
