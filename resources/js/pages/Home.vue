<template>
  <div class="min-h-screen bg-white">
    <!-- Hero Section -->
    <div class="bg-gradient-to-b from-white to-[#FAFAFA]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <header class="pt-6 sm:pt-8 pb-4 flex items-center justify-between">
          <div class="flex items-center">
            <h2 class="text-xl sm:text-2xl font-semibold text-[#0A0A0A] tracking-tight">Reservify</h2>
          </div>
          <nav class="flex items-center gap-2 sm:gap-4">
            <router-link
              to="/login"
              class="px-3 sm:px-4 py-2 text-sm sm:text-base text-[#525252] hover:text-[#0A0A0A] font-medium transition-colors duration-150"
            >
              Sign In
            </router-link>
            <router-link
              to="/register"
              class="px-3 sm:px-4 py-2 text-sm sm:text-base bg-[#2563EB] text-white rounded-lg font-medium
                     hover:bg-[#1D4ED8] transition-all duration-150 hover:-translate-y-px whitespace-nowrap"
            >
              Get Started
            </router-link>
          </nav>
        </header>

        <!-- Hero Content -->
        <div class="py-16 sm:py-24 lg:py-32">
          <div class="max-w-4xl mx-auto text-center px-4">
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-semibold text-[#0A0A0A] tracking-tight mb-6 leading-[1.1]">
              Effortless Booking.<br class="hidden sm:block" />
              <span class="sm:inline"> </span>Simplified Scheduling.
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-[#525252] mb-8 sm:mb-12 max-w-2xl mx-auto leading-relaxed px-4">
              A modern reservation system designed for professionals. Manage appointments,
              track bookings, and delight your customers with seamless scheduling.
            </p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
              <router-link
                to="/booking"
                class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-[#2563EB] text-white rounded-xl font-medium text-base sm:text-lg
                       hover:bg-[#1D4ED8] transition-all duration-150
                       hover:-translate-y-0.5 shadow-sm hover:shadow-md text-center"
              >
                Book an Appointment
              </router-link>
              <router-link
                to="/register"
                class="w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 border-2 border-[#E5E5E5] text-[#0A0A0A] rounded-xl
                       font-medium text-base sm:text-lg hover:border-[#D4D4D4] hover:bg-[#FAFAFA]
                       transition-all duration-150 text-center"
              >
                Create Account
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 sm:py-24 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12 sm:mb-16">
          <h2 class="text-3xl sm:text-4xl font-semibold text-[#0A0A0A] mb-3 sm:mb-4">Everything You Need</h2>
          <p class="text-base sm:text-lg text-[#525252] max-w-2xl mx-auto px-4">
            Powerful features designed to streamline your booking experience
          </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
          <!-- Feature 1 -->
          <div class="bg-[#FAFAFA] rounded-2xl p-6 sm:p-8 border border-[#E5E5E5] transition-all duration-200 hover:-translate-y-1 hover:shadow-md">
            <div class="w-12 h-12 bg-[#2563EB]/10 rounded-xl flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-[#2563EB]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-semibold text-[#0A0A0A] mb-2">Smart Scheduling</h3>
            <p class="text-sm sm:text-base text-[#525252] leading-relaxed">
              Real-time availability checking with intelligent conflict detection and automatic slot management.
            </p>
          </div>

          <!-- Feature 2 -->
          <div class="bg-[#FAFAFA] rounded-2xl p-6 sm:p-8 border border-[#E5E5E5] transition-all duration-200 hover:-translate-y-1 hover:shadow-md">
            <div class="w-12 h-12 bg-[#059669]/10 rounded-xl flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-[#059669]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-semibold text-[#0A0A0A] mb-2">Easy Management</h3>
            <p class="text-sm sm:text-base text-[#525252] leading-relaxed">
              Manage all your bookings from one dashboard. Cancel, reschedule, and track appointments effortlessly.
            </p>
          </div>

          <!-- Feature 3 -->
          <div class="bg-[#FAFAFA] rounded-2xl p-6 sm:p-8 border border-[#E5E5E5] transition-all duration-200 hover:-translate-y-1 hover:shadow-md sm:col-span-2 lg:col-span-1">
            <div class="w-12 h-12 bg-[#D97706]/10 rounded-xl flex items-center justify-center mb-4">
              <svg class="w-6 h-6 text-[#D97706]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
              </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-semibold text-[#0A0A0A] mb-2">Lightning Fast</h3>
            <p class="text-sm sm:text-base text-[#525252] leading-relaxed">
              Built with modern technology for instant responses and seamless user experience across all devices.
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="py-16 sm:py-24 bg-gradient-to-b from-white to-[#FAFAFA]">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl sm:text-4xl font-semibold text-[#0A0A0A] mb-3 sm:mb-4">Ready to Get Started?</h2>
        <p class="text-base sm:text-lg text-[#525252] mb-6 sm:mb-8 max-w-2xl mx-auto px-4">
          Join professionals who trust Reservify for their scheduling needs.
        </p>
        <router-link
          to="/booking"
          class="inline-block w-full sm:w-auto px-6 sm:px-8 py-3 sm:py-4 bg-[#2563EB] text-white rounded-xl font-medium text-base sm:text-lg
                 hover:bg-[#1D4ED8] transition-all duration-150
                 hover:-translate-y-0.5 shadow-sm hover:shadow-md"
        >
          Book Your First Appointment
        </router-link>
      </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white border-t border-[#E5E5E5] py-8 sm:py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center text-[#A3A3A3]">
          <p class="text-xs sm:text-sm">© 2025 Reservify. Modern booking made simple.</p>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup>
// Home page component
</script>
