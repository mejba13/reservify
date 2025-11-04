import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '@/utils/api'

/**
 * Authentication store for managing user state and authentication
 */
export const useAuthStore = defineStore('auth', () => {
  // State
  const user = ref(null)
  const token = ref(localStorage.getItem('auth_token'))

  // Getters
  const isAuthenticated = computed(() => !!token.value && !!user.value)
  const isAdmin = computed(() => user.value?.role === 'admin' || user.value?.role === 'provider')

  // Actions
  async function login(credentials) {
    try {
      const response = await api.post('/auth/login', credentials)
      token.value = response.data.token
      user.value = response.data.user
      localStorage.setItem('auth_token', token.value)
      return response.data
    } catch (error) {
      throw error
    }
  }

  async function register(userData) {
    try {
      const response = await api.post('/auth/register', userData)
      token.value = response.data.token
      user.value = response.data.user
      localStorage.setItem('auth_token', token.value)
      return response.data
    } catch (error) {
      throw error
    }
  }

  async function logout() {
    try {
      await api.post('/auth/logout')
    } catch (error) {
      console.error('Logout error:', error)
    } finally {
      token.value = null
      user.value = null
      localStorage.removeItem('auth_token')
    }
  }

  async function fetchUser() {
    try {
      const response = await api.get('/customer/profile')
      user.value = response.data.data
      return user.value
    } catch (error) {
      // If fetching user fails, clear auth state
      token.value = null
      user.value = null
      localStorage.removeItem('auth_token')
      throw error
    }
  }

  return {
    user,
    token,
    isAuthenticated,
    isAdmin,
    login,
    register,
    logout,
    fetchUser
  }
})
