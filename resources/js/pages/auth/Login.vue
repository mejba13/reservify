<template>
  <div class="min-h-screen flex items-center justify-center bg-[#FAFAFA] px-4">
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
          <h1 class="text-3xl font-semibold text-[#0A0A0A] mb-2">Welcome Back</h1>
          <p class="text-[#525252]">Sign in to manage your bookings</p>
        </div>

        <!-- Error Message -->
        <div v-if="error" class="mb-6 p-4 bg-[#DC2626]/10 border border-[#DC2626] rounded-lg">
          <p class="text-sm text-[#DC2626]">{{ error }}</p>
        </div>

        <!-- Login Form -->
        <form @submit.prevent="handleLogin" class="space-y-4">
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
            v-model="form.password"
            type="password"
            label="Password"
            placeholder="Enter your password"
            :error="errors.password"
            required
            autocomplete="current-password"
          />

          <Button
            type="submit"
            variant="primary"
            size="md"
            :loading="loading"
            :disabled="loading"
            full-width
          >
            Sign In
          </Button>
        </form>

        <!-- Register Link -->
        <div class="mt-6 text-center">
          <p class="text-sm text-[#525252]">
            Don't have an account?
            <router-link to="/register" class="text-[#2563EB] hover:underline font-medium">
              Create Account
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
  email: '',
  password: ''
})

const errors = reactive({
  email: '',
  password: ''
})

const loading = ref(false)
const error = ref('')

const handleLogin = async () => {
  // Reset errors
  error.value = ''
  errors.email = ''
  errors.password = ''

  // Validate
  if (!form.email) {
    errors.email = 'Email is required'
    return
  }
  if (!form.password) {
    errors.password = 'Password is required'
    return
  }

  loading.value = true

  try {
    await authStore.login({
      email: form.email,
      password: form.password
    })

    // Redirect to dashboard
    router.push('/dashboard')
  } catch (err) {
    error.value = err.response?.data?.message || 'Login failed. Please try again.'

    // Handle validation errors
    if (err.response?.data?.errors) {
      Object.assign(errors, err.response.data.errors)
    }
  } finally {
    loading.value = false
  }
}
</script>
