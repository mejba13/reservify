<template>
  <div class="min-h-screen flex items-center justify-center bg-[#FAFAFA] px-4 py-12">
    <div class="w-full max-w-md">
      <!-- Back to Home -->
      <div class="mb-6 text-center">
        <router-link
          to="/"
          class="inline-flex items-center gap-2 text-sm text-[#525252] hover:text-[#0A0A0A] transition-colors duration-150"
        >
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          Back to Home
        </router-link>
      </div>

      <div class="bg-white rounded-xl border border-[#E5E5E5] p-8 shadow-sm">
        <!-- Header -->
        <div class="text-center mb-8">
          <h1 class="text-3xl font-semibold text-[#0A0A0A] mb-2">Create Account</h1>
          <p class="text-[#525252]">Get started with Reservify</p>
        </div>

        <!-- Error Message -->
        <div v-if="error" class="mb-6 p-4 bg-[#DC2626]/10 border border-[#DC2626] rounded-lg">
          <p class="text-sm text-[#DC2626]">{{ error }}</p>
        </div>

        <!-- Registration Form -->
        <form @submit.prevent="handleRegister" class="space-y-4">
          <Input
            v-model="form.name"
            type="text"
            label="Full Name"
            placeholder="John Doe"
            :error="errors.name"
            required
            autocomplete="name"
          />

          <div class="grid grid-cols-2 gap-4">
            <Input
              v-model="form.first_name"
              type="text"
              label="First Name"
              placeholder="John"
              :error="errors.first_name"
              required
            />

            <Input
              v-model="form.last_name"
              type="text"
              label="Last Name"
              placeholder="Doe"
              :error="errors.last_name"
              required
            />
          </div>

          <Input
            v-model="form.email"
            type="email"
            label="Email Address"
            placeholder="you@example.com"
            :error="errors.email"
            required
            autocomplete="email"
          />

          <Input
            v-model="form.phone"
            type="tel"
            label="Phone Number"
            placeholder="+1 (555) 123-4567"
            :error="errors.phone"
          />

          <Input
            v-model="form.password"
            type="password"
            label="Password"
            placeholder="At least 8 characters"
            :error="errors.password"
            required
            autocomplete="new-password"
          />

          <Input
            v-model="form.password_confirmation"
            type="password"
            label="Confirm Password"
            placeholder="Re-enter your password"
            :error="errors.password_confirmation"
            required
            autocomplete="new-password"
          />

          <Button
            type="submit"
            variant="primary"
            size="md"
            :loading="loading"
            :disabled="loading"
            full-width
          >
            Create Account
          </Button>
        </form>

        <!-- Login Link -->
        <div class="mt-6 text-center">
          <p class="text-sm text-[#525252]">
            Already have an account?
            <router-link to="/login" class="text-[#2563EB] hover:underline font-medium">
              Sign In
            </router-link>
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import Input from '@/components/ui/Input.vue'
import Button from '@/components/ui/Button.vue'

const router = useRouter()
const authStore = useAuthStore()

const form = reactive({
  name: '',
  first_name: '',
  last_name: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: ''
})

const errors = reactive({
  name: '',
  first_name: '',
  last_name: '',
  email: '',
  phone: '',
  password: '',
  password_confirmation: ''
})

const loading = ref(false)
const error = ref('')

const handleRegister = async () => {
  // Reset errors
  error.value = ''
  Object.keys(errors).forEach(key => errors[key] = '')

  // Basic validation
  if (!form.name || !form.first_name || !form.last_name || !form.email || !form.password) {
    error.value = 'Please fill in all required fields'
    return
  }

  if (form.password !== form.password_confirmation) {
    errors.password_confirmation = 'Passwords do not match'
    return
  }

  loading.value = true

  try {
    await authStore.register(form)

    // Redirect to dashboard
    router.push('/dashboard')
  } catch (err) {
    error.value = err.response?.data?.message || 'Registration failed. Please try again.'

    // Handle validation errors
    if (err.response?.data?.errors) {
      Object.assign(errors, err.response.data.errors)
    }
  } finally {
    loading.value = false
  }
}
</script>
