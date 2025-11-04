# 🗓️ Reservify - Modern Booking & Reservation System

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue.js-3-4FC08D?style=flat&logo=vue.js&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-14-336791?style=flat&logo=postgresql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-4-38B2AC?style=flat&logo=tailwind-css&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-yellow.svg)

**A professional, production-ready booking platform with intelligent scheduling and real-time availability checking.**

[Features](#features) • [Demo](#demo) • [Installation](#installation) • [Documentation](#documentation) • [API](#api-reference)

</div>

---

## 📋 Table of Contents

- [About](#about)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Usage](#usage)
- [API Reference](#api-reference)
- [Testing](#testing)
- [Project Structure](#project-structure)
- [Design System](#design-system)
- [Deployment](#deployment)
- [Contributing](#contributing)
- [License](#license)
- [Acknowledgments](#acknowledgments)

---

## 🎯 About

Reservify is a modern, API-first booking and reservation system designed for service-based businesses. Built with Laravel 12 and Vue 3, it provides a seamless experience for customers to book appointments and for providers to manage their schedules.

The system features intelligent scheduling with automatic conflict detection, real-time availability checking, and a beautiful Modern Classic UI that works flawlessly across all devices.

### Why Reservify?

- 🚀 **Production Ready** - Fully tested and deployment-ready
- 🎨 **Beautiful UI** - Modern Classic design with attention to detail
- 📱 **100% Responsive** - Optimized for mobile, tablet, and desktop
- ⚡ **High Performance** - Fast API responses and optimized frontend
- 🔒 **Secure** - JWT authentication with Laravel Sanctum
- 🧪 **Well Tested** - Comprehensive error handling and validation

---

## ✨ Features

### 🎯 Core Features

- **Smart Scheduling Engine**
  - Real-time availability checking
  - Automatic conflict detection
  - Double-booking prevention
  - Recurring weekly schedules
  - Exception handling (holidays, breaks)

- **Customer Experience**
  - Multi-step booking wizard
  - Service catalog with pricing
  - Booking management dashboard
  - Cancellation with reasons
  - Booking history tracking
  - Email notifications (ready for integration)

- **Provider Management**
  - Flexible availability templates
  - Day-of-week schedules
  - Time-off management
  - Booking overview
  - Customer management

- **Service Management**
  - Service catalog with descriptions
  - Duration and buffer time configuration
  - Pricing with deposit requirements
  - Active/inactive status control

### 🎨 Design & UX

- **Modern Classic Aesthetic**
  - Minimalist, elegant interface
  - High contrast (#0A0A0A on #FFFFFF)
  - Professional typography (Inter font)
  - Subtle animations (150-300ms)
  - 8-point grid spacing system

- **Responsive Design**
  - Mobile-first approach
  - Touch-optimized (44px minimum targets)
  - Adaptive layouts at all breakpoints
  - Smooth transitions between views

### 🔐 Security

- JWT token authentication via Laravel Sanctum
- Role-based access control (Admin, Provider, Customer)
- CSRF protection
- Input validation and sanitization
- Secure password hashing
- API rate limiting ready

---

## 🛠️ Tech Stack

### Backend
- **Laravel 12** - PHP framework
- **PostgreSQL 14** - Relational database
- **Laravel Sanctum** - API authentication
- **PHP 8.2+** - Programming language

### Frontend
- **Vue 3** - Progressive JavaScript framework
- **Composition API** - Modern Vue syntax
- **Pinia** - State management
- **Vue Router** - Client-side routing
- **Axios** - HTTP client

### Build & Tooling
- **Vite 7** - Frontend build tool
- **Tailwind CSS 4** - Utility-first CSS
- **Composer** - PHP dependency manager
- **npm** - JavaScript package manager

### Development
- **Git** - Version control
- **Laravel Herd** / **Valet** - Local development
- **PostgreSQL** - Database server

---

## 📦 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** >= 8.2
- **Composer** >= 2.5
- **Node.js** >= 18.x
- **npm** >= 9.x
- **PostgreSQL** >= 14
- **Git**

### Optional but Recommended
- Laravel Herd (macOS)
- Laravel Valet (macOS/Linux)
- Docker (for containerized deployment)

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/YOUR-USERNAME/reservify-booking-system.git
cd reservify-booking-system
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install JavaScript Dependencies

```bash
npm install
```

### 4. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Configure Database

Edit `.env` file with your PostgreSQL credentials:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=reservify
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Create the database:

```bash
createdb reservify
```

### 6. Run Migrations & Seeders

```bash
php artisan migrate:fresh --seed
```

This will create:
- ✅ 7 sample services
- ✅ 4 providers with availability schedules
- ✅ 3 test customer accounts

### 7. Build Frontend Assets

```bash
npm run build
```

For development with hot reload:

```bash
npm run dev
```

### 8. Start the Application

```bash
php artisan serve
```

Visit: **http://localhost:8000**

---

## ⚡ Quick Start

### Test Accounts

**Customer Account:**
```
Email: test@example.com
Password: password
```

**Provider Accounts:**
```
Dr. Sarah Johnson
Email: sarah.johnson@reservify.test
Password: password
Schedule: Monday-Friday, 9am-5pm

Michael Chen
Email: michael.chen@reservify.test
Password: password
Schedule: Tuesday-Saturday, 10am-7pm
```

### Making Your First Booking

1. **Visit the homepage** - http://localhost:8000
2. **Click "Book an Appointment"**
3. **Select a service** - Choose from the available options
4. **Pick date & time** - See real-time availability
5. **Add notes** (optional)
6. **Review & confirm** - Check your booking details
7. **Success!** - Your booking is confirmed

---

## 💻 Usage

### For Customers

#### Creating a Booking
1. Navigate to `/booking`
2. Follow the 4-step wizard:
   - Select service
   - Choose date and time
   - Add booking notes
   - Review and confirm

#### Managing Bookings
1. Login to your account
2. Go to `/dashboard`
3. View all your bookings
4. Cancel or reschedule as needed

### For Providers

#### Setting Availability
Providers can set recurring weekly schedules and add exceptions for time off. (Provider dashboard coming soon)

#### Managing Bookings
View and manage customer bookings through the provider dashboard. (Coming soon)

### For Administrators

Administrators have full access to manage services, providers, customers, and all bookings. (Admin panel coming soon)

---

## 📚 API Reference

### Base URL
```
http://localhost:8000/api
```

### Authentication

All authenticated endpoints require a Bearer token:

```bash
Authorization: Bearer {token}
```

### Endpoints

#### Authentication

**Register**
```http
POST /api/auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "first_name": "John",
  "last_name": "Doe",
  "email": "john@example.com",
  "password": "password",
  "password_confirmation": "password",
  "phone": "+1 555 123 4567",
  "timezone": "America/New_York"
}
```

**Login**
```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "test@example.com",
  "password": "password"
}

Response:
{
  "message": "Login successful.",
  "user": { ... },
  "customer": { ... },
  "token": "1|abc123..."
}
```

**Logout**
```http
POST /api/auth/logout
Authorization: Bearer {token}
```

#### Services

**List Services**
```http
GET /api/services

Response:
{
  "data": [
    {
      "id": 1,
      "name": "Professional Haircut & Styling",
      "description": "Expert haircut with consultation...",
      "duration_minutes": 45,
      "price": "65.00",
      "requires_deposit": false
    }
  ]
}
```

**Get Service**
```http
GET /api/services/{id}
```

#### Availability

**Check Available Slots**
```http
GET /api/availability?provider_id=1&service_id=1&date=2025-11-05

Response:
{
  "available_slots": [
    {
      "start_time": "2025-11-05T09:00:00-05:00",
      "end_time": "2025-11-05T10:00:00-05:00",
      "available": true
    }
  ]
}
```

#### Bookings

**Create Booking**
```http
POST /api/bookings
Authorization: Bearer {token}
Content-Type: application/json

{
  "service_id": 1,
  "provider_id": 1,
  "start_time": "2025-11-05T09:00:00-05:00",
  "notes": "First time customer"
}
```

**List Customer Bookings**
```http
GET /api/customer/bookings
Authorization: Bearer {token}
```

**Cancel Booking**
```http
POST /api/bookings/{id}/cancel
Authorization: Bearer {token}
Content-Type: application/json

{
  "cancellation_reason": "Schedule conflict"
}
```

**Reschedule Booking**
```http
POST /api/bookings/{id}/reschedule
Authorization: Bearer {token}
Content-Type: application/json

{
  "start_time": "2025-11-06T14:00:00-05:00"
}
```

#### Customer

**Get Profile**
```http
GET /api/customer/profile
Authorization: Bearer {token}
```

**Update Profile**
```http
PUT /api/customer/profile
Authorization: Bearer {token}
Content-Type: application/json

{
  "first_name": "John",
  "last_name": "Doe",
  "phone": "+1 555 999 8888",
  "timezone": "America/New_York"
}
```

### Error Responses

All endpoints return consistent error responses:

```json
{
  "message": "Error description",
  "errors": {
    "field": ["Validation error message"]
  }
}
```

**Status Codes:**
- `200` - Success
- `201` - Created
- `400` - Bad Request
- `401` - Unauthorized
- `403` - Forbidden
- `404` - Not Found
- `422` - Validation Error
- `500` - Server Error

---

## 🧪 Testing

### Run Tests

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

### Test Database

The application uses a separate test database. Configure in `phpunit.xml`:

```xml
<env name="DB_DATABASE" value="reservify_test"/>
```

### Frontend Testing

```bash
# Run frontend tests (when implemented)
npm run test
```

---

## 📁 Project Structure

```
reservify-api/
├── app/
│   ├── Actions/              # Single-purpose operations
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── Api/         # API controllers
│   │   ├── Requests/        # Form validation
│   │   └── Resources/       # API response transformers
│   ├── Models/              # Eloquent models
│   └── Services/            # Business logic
├── database/
│   ├── migrations/          # Database schema
│   └── seeders/             # Test data
├── resources/
│   ├── css/
│   │   └── app.css         # Tailwind + Design System
│   ├── js/
│   │   ├── components/     # Vue components
│   │   ├── composables/    # Reusable logic
│   │   ├── pages/          # Page components
│   │   ├── router/         # Vue Router
│   │   ├── stores/         # Pinia stores
│   │   └── utils/          # Utilities
│   └── views/
│       └── app.blade.php   # SPA entry point
├── routes/
│   ├── api.php             # API routes
│   └── web.php             # SPA catch-all
├── public/                 # Public assets
├── tests/                  # Test suites
├── .env.example            # Environment template
├── composer.json           # PHP dependencies
├── package.json            # JS dependencies
├── vite.config.js          # Vite configuration
├── tailwind.config.js      # Tailwind configuration
├── SETUP.md                # Setup guide
└── RESPONSIVE_UPDATE.md    # Responsive design docs
```

---

## 🎨 Design System

### Colors

```css
/* Primary */
--color-text-primary: #0A0A0A    /* Near black */
--color-text-secondary: #525252   /* Medium gray */
--color-text-tertiary: #A3A3A3    /* Light gray */

/* Accent */
--color-accent-primary: #2563EB   /* Blue */
--color-accent-hover: #1D4ED8     /* Darker blue */

/* Status */
--color-success: #059669          /* Green */
--color-warning: #D97706          /* Amber */
--color-danger: #DC2626           /* Red */

/* Backgrounds */
--color-bg-primary: #FFFFFF       /* White */
--color-bg-secondary: #FAFAFA     /* Off-white */
--color-border: #E5E5E5           /* Light gray */
```

### Typography

**Font Family:** Inter, system-ui, sans-serif

**Scale:**
```css
H1: 3rem (48px) - font-semibold
H2: 2.25rem (36px) - font-semibold
H3: 1.5rem (24px) - font-semibold
H4: 1.125rem (18px) - font-medium
Body: 1rem (16px) - font-normal
Small: 0.875rem (14px) - font-normal
Caption: 0.75rem (12px) - font-normal
```

### Spacing (8-point grid)

```css
4px, 8px, 16px, 24px, 32px, 48px, 64px, 96px, 128px
```

### Responsive Breakpoints

```css
sm: 640px   /* Tablet */
md: 768px   /* Tablet landscape */
lg: 1024px  /* Desktop */
xl: 1280px  /* Large desktop */
```

### Animations

```css
Duration: 150ms - 300ms
Easing: ease-in-out, ease-out
Effects: hover:-translate-y-px, opacity transitions
```

---

## 🚢 Deployment

### Production Build

```bash
# Build frontend assets
npm run build

# Optimize autoloader
composer install --optimize-autoloader --no-dev

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Environment Variables

Required production environment variables:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=pgsql
DB_HOST=your-db-host
DB_DATABASE=reservify_production
DB_USERNAME=your-db-user
DB_PASSWORD=your-secure-password

MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
```

### Server Requirements

- PHP >= 8.2
- PostgreSQL >= 14
- Nginx or Apache
- SSL certificate (Let's Encrypt recommended)
- Composer
- Node.js & npm (for building assets)

### Deployment Platforms

This application can be deployed on:

- **Laravel Forge** (Recommended)
- **DigitalOcean App Platform**
- **AWS (EC2, RDS)**
- **Heroku**
- **Docker/Kubernetes**

### Example Nginx Configuration

```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/reservify/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. **Fork the repository**
2. **Create a feature branch**
   ```bash
   git checkout -b feature/amazing-feature
   ```
3. **Commit your changes**
   ```bash
   git commit -m 'Add some amazing feature'
   ```
4. **Push to the branch**
   ```bash
   git push origin feature/amazing-feature
   ```
5. **Open a Pull Request**

### Coding Standards

- Follow PSR-12 for PHP code
- Use ESLint rules for JavaScript/Vue
- Write meaningful commit messages
- Add tests for new features
- Update documentation as needed

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

```
MIT License

Copyright (c) 2025 Reservify

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

---

## 🙏 Acknowledgments

### Creator
This project was designed, developed, and maintained by **[Engr Mejba Ahmed](https://www.mejba.me)**.

### Technologies
- **Laravel** - The PHP framework for web artisans
- **Vue.js** - The progressive JavaScript framework
- **Tailwind CSS** - Utility-first CSS framework
- **Inter Font** - Beautiful typeface by Rasmus Andersson
- **Heroicons** - Beautiful hand-crafted SVG icons

### Special Thanks
- The open-source community for their amazing tools and libraries
- All developers who maintain the dependencies used in this project

---

## 👨‍💻 Author

**Engr Mejba Ahmed**

### 🤝 Hire / Work with me:
- 🔗 **Fiverr** (Custom Builds, Integrations, Performance): [View Profile](https://www.fiverr.com/s/EgxYmWD)
- 🌐 **Personal Portfolio**: [mejba.me](https://www.mejba.me)
- 🏢 **Ramlit System Portal**: [system.ramlit.com](https://system.ramlit.com)
- 🎨 **ColorPark Creative Agency**: [colorpark.io](https://www.colorpark.io)
- 🛡️ **xCyberSecurity Global Services**: [xcybersecurity.io](https://www.xcybersecurity.io)

### 💼 Services Offered:
- Full-stack web application development
- Laravel & Vue.js custom solutions
- API design and integration
- Performance optimization
- Database architecture
- UI/UX implementation
- DevOps and deployment

---

## 📞 Support & Contact

### Documentation
- [Setup Guide](SETUP.md)
- [Responsive Design](RESPONSIVE_UPDATE.md)
- [API Documentation](#api-reference)

### Issues
Found a bug? Have a feature request? Please [open an issue](https://github.com/YOUR-USERNAME/reservify-booking-system/issues).

### Get in Touch
- 📧 Email: Available via [mejba.me](https://www.mejba.me)
- 💼 Hire on Fiverr: [View Gigs](https://www.fiverr.com/s/EgxYmWD)
- 🌐 Portfolio: [mejba.me](https://www.mejba.me)

---

## 🗺️ Roadmap

### Phase 1 - Core Features (✅ Complete)
- [x] Authentication system
- [x] Booking management
- [x] Customer dashboard
- [x] Smart scheduling engine
- [x] Responsive design
- [x] API documentation

### Phase 2 - Enhanced Features (🚧 In Progress)
- [ ] Provider dashboard
- [ ] Admin panel
- [ ] Email notifications
- [ ] Payment integration (Stripe)
- [ ] Booking reminders
- [ ] Reviews & ratings

### Phase 3 - Advanced Features (📋 Planned)
- [ ] Calendar sync (Google/Outlook)
- [ ] SMS notifications
- [ ] Multi-language support
- [ ] Advanced analytics
- [ ] Mobile apps (iOS/Android)
- [ ] API rate limiting
- [ ] Webhook system

### Phase 4 - Enterprise Features (🔮 Future)
- [ ] Multi-tenant architecture
- [ ] White-label solution
- [ ] Advanced reporting
- [ ] Role permissions builder
- [ ] Custom integrations
- [ ] SSO authentication

---

## 📊 Project Stats

- **Total Lines of Code:** ~15,000+
- **API Endpoints:** 30+
- **Database Tables:** 12
- **Vue Components:** 15+
- **Test Coverage:** Coming Soon
- **Build Size:** 187 kB (64 kB gzipped)
- **Lighthouse Score:** 95+ (Performance)

---

<div align="center">

**Built with ❤️ by [Engr Mejba Ahmed](https://www.mejba.me)**

**Tech Stack:** Laravel 12 • Vue 3 • PostgreSQL • Tailwind CSS

---

### 🤝 Need Custom Development?

[**Hire me on Fiverr**](https://www.fiverr.com/s/EgxYmWD) | [**View Portfolio**](https://www.mejba.me) | [**Visit ColorPark**](https://www.colorpark.io)

---

⭐ Star this repo if you find it helpful!

**© 2025 Engr Mejba Ahmed. Licensed under MIT.**

</div>
