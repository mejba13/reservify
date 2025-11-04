# Contributing to Reservify

First off, thank you for considering contributing to Reservify! It's people like you that make Reservify such a great tool.

## Code of Conduct

This project and everyone participating in it is governed by our Code of Conduct. By participating, you are expected to uphold this code.

## How Can I Contribute?

### Reporting Bugs

Before creating bug reports, please check the existing issues as you might find out that you don't need to create one. When you are creating a bug report, please include as many details as possible:

* **Use a clear and descriptive title**
* **Describe the exact steps which reproduce the problem**
* **Provide specific examples to demonstrate the steps**
* **Describe the behavior you observed after following the steps**
* **Explain which behavior you expected to see instead and why**
* **Include screenshots and animated GIFs if possible**

### Suggesting Enhancements

Enhancement suggestions are tracked as GitHub issues. When creating an enhancement suggestion, please include:

* **Use a clear and descriptive title**
* **Provide a step-by-step description of the suggested enhancement**
* **Provide specific examples to demonstrate the steps**
* **Describe the current behavior and explain which behavior you expected to see instead**
* **Explain why this enhancement would be useful**

### Pull Requests

* Fill in the required template
* Do not include issue numbers in the PR title
* Follow the PHP and JavaScript styleguides
* Include thoughtfully-worded, well-structured tests
* Document new code
* End all files with a newline

## Development Setup

### Prerequisites

* PHP >= 8.2
* Composer >= 2.5
* Node.js >= 18.x
* PostgreSQL >= 14

### Setup Steps

1. Fork and clone the repository
```bash
git clone https://github.com/YOUR-USERNAME/reservify-booking-system.git
cd reservify-booking-system
```

2. Install dependencies
```bash
composer install
npm install
```

3. Set up environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database and run migrations
```bash
php artisan migrate:fresh --seed
```

5. Build assets
```bash
npm run dev
```

6. Start development server
```bash
php artisan serve
```

## Styleguides

### Git Commit Messages

* Use the present tense ("Add feature" not "Added feature")
* Use the imperative mood ("Move cursor to..." not "Moves cursor to...")
* Limit the first line to 72 characters or less
* Reference issues and pull requests liberally after the first line
* Consider starting the commit message with an applicable emoji:
    * 🎨 `:art:` when improving the format/structure of the code
    * 🐎 `:racehorse:` when improving performance
    * 📝 `:memo:` when writing docs
    * 🐛 `:bug:` when fixing a bug
    * 🔥 `:fire:` when removing code or files
    * ✅ `:white_check_mark:` when adding tests
    * 🔒 `:lock:` when dealing with security
    * ⬆️ `:arrow_up:` when upgrading dependencies
    * ⬇️ `:arrow_down:` when downgrading dependencies

### PHP Styleguide

* Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standard
* Use type hints where possible
* Document all public methods and classes
* Keep methods short and focused
* Use meaningful variable and method names

Example:
```php
<?php

namespace App\Services;

use App\Models\Booking;
use Illuminate\Support\Carbon;

/**
 * Service for managing booking operations
 */
class BookingService
{
    /**
     * Create a new booking
     *
     * @param Customer $customer
     * @param array $data
     * @return Booking
     */
    public function createBooking(Customer $customer, array $data): Booking
    {
        // Implementation
    }
}
```

### JavaScript/Vue Styleguide

* Use ES6+ features
* Follow the [Vue.js Style Guide](https://vuejs.org/style-guide/)
* Use Composition API for new components
* Use meaningful component and variable names
* Keep components small and focused
* Document complex logic

Example:
```vue
<script setup>
import { ref, computed } from 'vue'

// State
const bookings = ref([])
const loading = ref(false)

// Computed
const activeBookings = computed(() => {
  return bookings.value.filter(b => b.status === 'active')
})

// Methods
const fetchBookings = async () => {
  loading.value = true
  try {
    // Implementation
  } finally {
    loading.value = false
  }
}
</script>
```

### CSS/Tailwind Styleguide

* Use Tailwind utility classes
* Follow mobile-first responsive design
* Keep custom CSS minimal
* Use design system tokens (colors, spacing)
* Maintain consistent spacing (8-point grid)

Example:
```vue
<template>
  <div class="
    px-4 sm:px-6 lg:px-8
    py-6 sm:py-8
    bg-white
    rounded-xl
    shadow-sm
    hover:shadow-md
    transition-shadow duration-200
  ">
    <!-- Content -->
  </div>
</template>
```

## Testing

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/BookingTest.php

# Run with coverage
php artisan test --coverage
```

### Writing Tests

* Write tests for all new features
* Ensure tests are independent
* Use descriptive test names
* Follow AAA pattern (Arrange, Act, Assert)

Example:
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Customer;

class BookingTest extends TestCase
{
    /** @test */
    public function customer_can_create_booking()
    {
        // Arrange
        $customer = Customer::factory()->create();
        $this->actingAs($customer->user);

        // Act
        $response = $this->postJson('/api/bookings', [
            'service_id' => 1,
            'provider_id' => 1,
            'start_time' => now()->addDay(),
        ]);

        // Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas('bookings', [
            'customer_id' => $customer->id,
        ]);
    }
}
```

## Documentation

* Update README.md if you change functionality
* Add comments for complex logic
* Update API documentation for new endpoints
* Include JSDoc for complex JavaScript functions

## Questions?

Feel free to open an issue with the `question` label if you need clarification on anything.

## License

By contributing, you agree that your contributions will be licensed under the MIT License.
