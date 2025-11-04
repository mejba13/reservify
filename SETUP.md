# Reservify Setup Guide

## Overview
Reservify is a modern, API-first booking and reservation system built with Laravel 12 and Vue 3. This guide will help you get started with the fully seeded development environment.

## Prerequisites
- PHP 8.2+
- PostgreSQL 14+
- Composer
- Node.js 18+
- npm

## Quick Start

### 1. Database Setup
The database has been configured and seeded with test data. If you need to reset:

```bash
php artisan migrate:fresh --seed
```

This will create:
- **7 Services** (ranging from $45-$200)
- **4 Providers** with different specialties and availability schedules
- **3 Test Customers** for testing

### 2. Frontend Assets
Build the frontend assets:

```bash
npm run build
```

Or run the development server with hot reload:

```bash
npm run dev
```

### 3. Start Laravel Server
```bash
php artisan serve
```

Visit: `http://localhost:8000`

## Test Credentials

### Customer Accounts
```
Email: test@example.com
Password: password

Email: john.doe@example.com
Password: password

Email: jane.smith@example.com
Password: password
```

### Provider Accounts
```
Email: sarah.johnson@reservify.test
Password: password
Specialty: Medical Consultation
Schedule: Monday-Friday, 9am-5pm

Email: michael.chen@reservify.test
Password: password
Specialty: Massage Therapy
Schedule: Tuesday-Saturday, 10am-7pm

Email: jessica.martinez@reservify.test
Password: password
Specialty: Business Consulting
Schedule: Monday-Thursday, 8am-4pm

Email: david.thompson@reservify.test
Password: password
Specialty: Personal Training
Schedule: Monday-Saturday, 6am-2pm (Sat 8am-12pm)
```

## Seeded Services

1. **Professional Haircut & Styling** - $65 (45 min)
2. **Deep Tissue Massage** - $95 (60 min) - Requires $25 deposit
3. **Business Consultation** - $150 (90 min) - Requires $50 deposit
4. **Relaxation Massage** - $85 (60 min)
5. **Personal Training Session** - $75 (60 min)
6. **Legal Consultation** - $200 (45 min) - Requires $100 deposit
7. **Quick Wellness Check** - $45 (30 min)

## Key Features Implemented

### Backend (Laravel API)
✅ **Authentication System**
- JWT token-based auth via Laravel Sanctum
- User registration with customer profile creation
- Login/logout with token management
- Role-based access (admin, provider, customer)

✅ **Booking Management**
- Create, view, cancel, and reschedule bookings
- UUID-based public booking references
- Status tracking (pending, confirmed, completed, cancelled, no_show)
- Cancellation reasons and timestamps

✅ **Availability System**
- Smart time slot generation
- Provider availability templates (recurring weekly schedules)
- Availability exceptions (holidays, breaks)
- Double-booking prevention
- Real-time conflict detection

✅ **Services Management**
- Service catalog with pricing
- Duration and buffer time configuration
- Deposit requirements
- Active/inactive status

✅ **API Endpoints** (30+)
- RESTful API design
- Comprehensive error handling
- Request validation
- Resource transformers

### Frontend (Vue 3 SPA)
✅ **Landing Page**
- Professional hero section
- Features showcase
- Call-to-action sections
- Responsive design

✅ **Authentication Pages**
- Modern login form
- Comprehensive registration flow
- Error handling and validation
- Loading states

✅ **Booking Flow**
- 4-step wizard (Service → Date/Time → Details → Confirm)
- Visual progress indicator
- Service selection with pricing
- Real-time availability checking
- Time slot selection
- Booking summary and confirmation
- Success state

✅ **Customer Dashboard**
- Booking list with filtering
- Status badges (color-coded)
- Booking actions (cancel, reschedule, details)
- Cancel modal with reason
- Empty states
- Loading skeletons

✅ **UI Components**
- Button (4 variants, loading states, sizes)
- Input (validation, error states, textarea)
- Card (hover effects, padding variants)
- Modal (animations, backdrop blur, sizes)

### Design System
✅ **Modern Classic Aesthetic**
- Inter font family
- High contrast colors (#0A0A0A text, #2563EB accent)
- 8-point grid spacing
- Subtle animations (150-300ms)
- Professional polish

## Testing the Application

### 1. Test the Booking Flow (Guest)
1. Visit `http://localhost:8000`
2. Click "Book an Appointment"
3. Select a service
4. Choose a date (today or future)
5. Select an available time slot
6. Add notes (optional)
7. Review and confirm
8. You'll see a success message

**Note:** Guest bookings currently use provider ID 1 (Dr. Sarah Johnson). Provider selection will be added in future updates.

### 2. Test Customer Dashboard
1. Register a new account or login with test credentials
2. Create a booking through the booking flow
3. Visit the dashboard to see your bookings
4. Test the cancel functionality
5. Verify status updates

### 3. Test API Directly
Use Postman or curl:

```bash
# Register a new user
curl -X POST http://localhost:8000/api/auth/register \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Test User",
    "first_name": "Test",
    "last_name": "User",
    "email": "newuser@example.com",
    "password": "password",
    "password_confirmation": "password",
    "phone": "+1 555 999 8888"
  }'

# Login
curl -X POST http://localhost:8000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password"
  }'

# Get available services
curl http://localhost:8000/api/services

# Get available slots (replace date with future date)
curl "http://localhost:8000/api/availability?provider_id=1&service_id=1&date=2025-11-05"

# Get customer bookings (requires auth token)
curl http://localhost:8000/api/customer/bookings \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## Project Structure

```
reservify-api/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/  # API controllers
│   │   ├── Requests/          # Form validation
│   │   └── Resources/         # API responses
│   ├── Models/                # Eloquent models
│   ├── Services/              # Business logic
│   └── Actions/               # Single-purpose operations
├── database/
│   ├── migrations/            # Database schema
│   └── seeders/               # Test data
├── resources/
│   ├── css/
│   │   └── app.css           # Tailwind + Design System
│   ├── js/
│   │   ├── components/       # Vue components
│   │   ├── composables/      # Reusable logic
│   │   ├── pages/            # Page components
│   │   ├── stores/           # Pinia stores
│   │   ├── utils/            # Utilities
│   │   └── router/           # Vue Router
│   └── views/
│       └── app.blade.php     # SPA entry
└── routes/
    ├── api.php               # API routes
    └── web.php               # SPA catch-all
```

## Design System Reference

### Colors
```css
Primary Text:    #0A0A0A (near-black)
Secondary Text:  #525252 (medium gray)
Tertiary Text:   #A3A3A3 (light gray)
Accent Primary:  #2563EB (blue)
Accent Hover:    #1D4ED8 (darker blue)
Success:         #059669 (green)
Warning:         #D97706 (amber)
Danger:          #DC2626 (red)
Border:          #E5E5E5 (light gray)
Background:      #FAFAFA (off-white)
```

### Typography
```css
Heading 1: 3rem (48px) - font-semibold
Heading 2: 2.25rem (36px) - font-semibold
Heading 3: 1.5rem (24px) - font-semibold
Heading 4: 1.125rem (18px) - font-medium
Body Large: 1.125rem (18px) - font-normal
Body: 1rem (16px) - font-normal
Body Small: 0.875rem (14px) - font-normal
Caption: 0.75rem (12px) - font-normal
```

### Spacing (8-point grid)
```css
4px, 8px, 16px, 24px, 32px, 48px, 64px, 96px, 128px
```

## Next Steps

### Recommended Enhancements
1. **Provider Selection** - Add provider selection to booking flow
2. **Email Notifications** - Booking confirmations and reminders
3. **Payment Integration** - Stripe for deposits and payments
4. **Calendar Sync** - Google Calendar and Outlook integration
5. **Provider Dashboard** - Manage bookings, availability, and customers
6. **Admin Dashboard** - System overview and management
7. **Booking Rescheduling** - Frontend implementation (backend ready)
8. **Search & Filters** - Service categories, provider search
9. **Reviews & Ratings** - Customer feedback system
10. **Analytics** - Booking statistics and insights

### Code Quality
- All code follows PSR-12 standards
- Vue components use Composition API
- Comprehensive error handling
- Loading states and user feedback
- Mobile-responsive design
- Accessibility considerations

## Troubleshooting

### Database Issues
```bash
# Reset database
php artisan migrate:fresh --seed
```

### Build Issues
```bash
# Clear cache and rebuild
rm -rf node_modules
npm install
npm run build
```

### Permission Issues
```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
```

## Support
For issues or questions, please refer to the Laravel and Vue.js documentation:
- Laravel: https://laravel.com/docs
- Vue 3: https://vuejs.org/guide/
- Tailwind CSS: https://tailwindcss.com/docs

---

Built with ❤️ using Laravel 12, Vue 3, PostgreSQL, and Tailwind CSS
