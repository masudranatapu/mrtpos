<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BusinessTypeSeeder::class);
        $this->call(PackageSeeder::class);
        $this->call(PricingPlanSeeder::class);
        $this->call(TestimonialSeeder::class);
    }
}
