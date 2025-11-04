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
        $this->command->info('🌱 Seeding Reservify database...');
        $this->command->newLine();

        $this->call([
            ServiceSeeder::class,
            ProviderSeeder::class,
            CustomerSeeder::class,
        ]);

        $this->command->newLine();
        $this->command->info('✅ Database seeding completed successfully!');
        $this->command->info('📝 Test credentials:');
        $this->command->info('   Customer: test@example.com / password');
        $this->command->info('   Provider: sarah.johnson@reservify.test / password');
    }
}
