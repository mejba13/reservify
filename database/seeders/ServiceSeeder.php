<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Professional Haircut & Styling',
                'description' => 'Expert haircut with personalized styling consultation. Includes wash, cut, and blow-dry for a polished look.',
                'duration_minutes' => 45,
                'buffer_time_minutes' => 15,
                'price' => 65.00,
                'requires_deposit' => false,
                'deposit_amount' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Deep Tissue Massage',
                'description' => 'Therapeutic massage targeting muscle tension and knots. Perfect for stress relief and pain management.',
                'duration_minutes' => 60,
                'buffer_time_minutes' => 15,
                'price' => 95.00,
                'requires_deposit' => true,
                'deposit_amount' => 25.00,
                'is_active' => true,
            ],
            [
                'name' => 'Business Consultation',
                'description' => 'One-on-one strategy session to discuss your business goals and develop actionable plans.',
                'duration_minutes' => 90,
                'buffer_time_minutes' => 15,
                'price' => 150.00,
                'requires_deposit' => true,
                'deposit_amount' => 50.00,
                'is_active' => true,
            ],
            [
                'name' => 'Relaxation Massage',
                'description' => 'Gentle, soothing massage designed to promote relaxation and reduce stress. Uses light to medium pressure.',
                'duration_minutes' => 60,
                'buffer_time_minutes' => 15,
                'price' => 85.00,
                'requires_deposit' => false,
                'deposit_amount' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Personal Training Session',
                'description' => 'Customized fitness training with a certified personal trainer. Includes workout plan and nutrition guidance.',
                'duration_minutes' => 60,
                'buffer_time_minutes' => 0,
                'price' => 75.00,
                'requires_deposit' => false,
                'deposit_amount' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Legal Consultation',
                'description' => 'Confidential legal advice session covering various areas of law. Initial consultation to assess your case.',
                'duration_minutes' => 45,
                'buffer_time_minutes' => 15,
                'price' => 200.00,
                'requires_deposit' => true,
                'deposit_amount' => 100.00,
                'is_active' => true,
            ],
            [
                'name' => 'Quick Wellness Check',
                'description' => 'Express 30-minute session for a quick assessment and wellness tips.',
                'duration_minutes' => 30,
                'buffer_time_minutes' => 10,
                'price' => 45.00,
                'requires_deposit' => false,
                'deposit_amount' => 0,
                'is_active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        $this->command->info('✓ Created ' . count($services) . ' services');
    }
}
