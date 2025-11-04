<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\User;
use App\Models\AvailabilityTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $providers = [
            [
                'user' => [
                    'name' => 'Dr. Sarah Johnson',
                    'email' => 'sarah.johnson@reservify.test',
                    'password' => Hash::make('password'),
                    'role' => 'provider',
                ],
                'provider' => [
                    'name' => 'Dr. Sarah Johnson',
                    'email' => 'sarah.johnson@reservify.test',
                    'phone' => '+1 (555) 123-4567',
                    'specialty' => 'Medical Consultation',
                    'bio' => 'Board-certified physician with over 15 years of experience in family medicine.',
                    'timezone' => 'America/New_York',
                    'is_active' => true,
                ],
                'availability' => [
                    // Monday - Friday: 9am - 5pm
                    ['day_of_week' => 1, 'start_time' => '09:00:00', 'end_time' => '17:00:00'],
                    ['day_of_week' => 2, 'start_time' => '09:00:00', 'end_time' => '17:00:00'],
                    ['day_of_week' => 3, 'start_time' => '09:00:00', 'end_time' => '17:00:00'],
                    ['day_of_week' => 4, 'start_time' => '09:00:00', 'end_time' => '17:00:00'],
                    ['day_of_week' => 5, 'start_time' => '09:00:00', 'end_time' => '17:00:00'],
                ],
            ],
            [
                'user' => [
                    'name' => 'Michael Chen',
                    'email' => 'michael.chen@reservify.test',
                    'password' => Hash::make('password'),
                    'role' => 'provider',
                ],
                'provider' => [
                    'name' => 'Michael Chen',
                    'email' => 'michael.chen@reservify.test',
                    'phone' => '+1 (555) 234-5678',
                    'specialty' => 'Massage Therapy',
                    'bio' => 'Licensed massage therapist specializing in deep tissue and sports massage.',
                    'timezone' => 'America/New_York',
                    'is_active' => true,
                ],
                'availability' => [
                    // Tuesday - Saturday: 10am - 7pm
                    ['day_of_week' => 2, 'start_time' => '10:00:00', 'end_time' => '19:00:00'],
                    ['day_of_week' => 3, 'start_time' => '10:00:00', 'end_time' => '19:00:00'],
                    ['day_of_week' => 4, 'start_time' => '10:00:00', 'end_time' => '19:00:00'],
                    ['day_of_week' => 5, 'start_time' => '10:00:00', 'end_time' => '19:00:00'],
                    ['day_of_week' => 6, 'start_time' => '10:00:00', 'end_time' => '19:00:00'],
                ],
            ],
            [
                'user' => [
                    'name' => 'Jessica Martinez',
                    'email' => 'jessica.martinez@reservify.test',
                    'password' => Hash::make('password'),
                    'role' => 'provider',
                ],
                'provider' => [
                    'name' => 'Jessica Martinez',
                    'email' => 'jessica.martinez@reservify.test',
                    'phone' => '+1 (555) 345-6789',
                    'specialty' => 'Business Consulting',
                    'bio' => 'Strategic business consultant with expertise in startup growth and operations.',
                    'timezone' => 'America/Los_Angeles',
                    'is_active' => true,
                ],
                'availability' => [
                    // Monday - Thursday: 8am - 4pm
                    ['day_of_week' => 1, 'start_time' => '08:00:00', 'end_time' => '16:00:00'],
                    ['day_of_week' => 2, 'start_time' => '08:00:00', 'end_time' => '16:00:00'],
                    ['day_of_week' => 3, 'start_time' => '08:00:00', 'end_time' => '16:00:00'],
                    ['day_of_week' => 4, 'start_time' => '08:00:00', 'end_time' => '16:00:00'],
                ],
            ],
            [
                'user' => [
                    'name' => 'David Thompson',
                    'email' => 'david.thompson@reservify.test',
                    'password' => Hash::make('password'),
                    'role' => 'provider',
                ],
                'provider' => [
                    'name' => 'David Thompson',
                    'email' => 'david.thompson@reservify.test',
                    'phone' => '+1 (555) 456-7890',
                    'specialty' => 'Personal Training',
                    'bio' => 'Certified personal trainer and nutrition specialist focused on sustainable fitness.',
                    'timezone' => 'America/Chicago',
                    'is_active' => true,
                ],
                'availability' => [
                    // Monday - Friday: 6am - 2pm, Saturday: 8am - 12pm
                    ['day_of_week' => 1, 'start_time' => '06:00:00', 'end_time' => '14:00:00'],
                    ['day_of_week' => 2, 'start_time' => '06:00:00', 'end_time' => '14:00:00'],
                    ['day_of_week' => 3, 'start_time' => '06:00:00', 'end_time' => '14:00:00'],
                    ['day_of_week' => 4, 'start_time' => '06:00:00', 'end_time' => '14:00:00'],
                    ['day_of_week' => 5, 'start_time' => '06:00:00', 'end_time' => '14:00:00'],
                    ['day_of_week' => 6, 'start_time' => '08:00:00', 'end_time' => '12:00:00'],
                ],
            ],
        ];

        foreach ($providers as $providerData) {
            // Create user
            $user = User::create($providerData['user']);

            // Create provider
            $provider = Provider::create(array_merge(
                $providerData['provider'],
                ['user_id' => $user->id]
            ));

            // Create availability templates
            foreach ($providerData['availability'] as $availability) {
                AvailabilityTemplate::create(array_merge(
                    $availability,
                    ['provider_id' => $provider->id]
                ));
            }

            $this->command->info("✓ Created provider: {$provider->name} with " . count($providerData['availability']) . " availability slots");
        }
    }
}
