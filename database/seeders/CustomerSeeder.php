<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'user' => [
                    'name' => 'John Doe',
                    'email' => 'john.doe@example.com',
                    'password' => Hash::make('password'),
                    'role' => 'customer',
                ],
                'customer' => [
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'email' => 'john.doe@example.com',
                    'phone' => '+1 (555) 111-2222',
                    'timezone' => 'America/New_York',
                ],
            ],
            [
                'user' => [
                    'name' => 'Jane Smith',
                    'email' => 'jane.smith@example.com',
                    'password' => Hash::make('password'),
                    'role' => 'customer',
                ],
                'customer' => [
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                    'email' => 'jane.smith@example.com',
                    'phone' => '+1 (555) 222-3333',
                    'timezone' => 'America/Los_Angeles',
                ],
            ],
            [
                'user' => [
                    'name' => 'Test User',
                    'email' => 'test@example.com',
                    'password' => Hash::make('password'),
                    'role' => 'customer',
                ],
                'customer' => [
                    'first_name' => 'Test',
                    'last_name' => 'User',
                    'email' => 'test@example.com',
                    'phone' => '+1 (555) 999-8888',
                    'timezone' => 'America/Chicago',
                ],
            ],
        ];

        foreach ($customers as $customerData) {
            // Create user
            $user = User::create($customerData['user']);

            // Create customer
            $customer = Customer::create(array_merge(
                $customerData['customer'],
                ['user_id' => $user->id]
            ));

            $this->command->info("✓ Created customer: {$customer->first_name} {$customer->last_name}");
        }
    }
}
