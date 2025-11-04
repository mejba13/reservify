import axios from 'axios'

/**
 * Axios instance configured for the Reservify API
 * Handles authentication, base URL, and response formatting
 */
const api = axios.create({
  baseURL: '/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
})

/**
 * Request interceptor to add auth token
 */
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('auth_token')
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    return config
  },
  (error) => {
    return Promise.reject(error)
  }
)

/**
 * Response interceptor to handle errors globally
 */
api.interceptors.response.use(
  (response) => {
    return response
  },
  (error) => {
    // Handle 401 Unauthorized
    if (error.response?.status === 401) {
      localStorage.removeItem('auth_token')
      window.location.href = '/login'
    }

    // Handle 403 Forbidden
    if (error.response?.status === 403) {
      console.error('Access forbidden')
    }

    // Handle 422 Validation errors
    if (error.response?.status === 422) {
      // Validation errors are handled by individual components
      return Promise.reject(error)
    }

    // Handle 500 Server errors
    if (error.response?.status >= 500) {
      console.error('Server error occurred')
    }

    return Promise.reject(error)
  }
)

export default api
