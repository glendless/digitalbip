<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            HeadOfFamilySeeder::class,
            SocialAssistanceSeeder::class,
            EventSeeder::class,
            EventParticipantSeeder::class,
            DevelopmentSeeder::class,
            DevelopmentApplicantSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
