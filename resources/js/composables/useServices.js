import { ref } from 'vue'
import api from '@/utils/api'

/**
 * Services Composable
 *
 * Manages services data and API interactions
 */
export function useServices() {
  const services = ref([])
  const loading = ref(false)
  const error = ref(null)

  /**
   * Fetch available services
   */
  const fetchServices = async () => {
    loading.value = true
    error.value = null

    try {
      const response = await api.get('/services')
      services.value = response.data.data
      return services.value
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to fetch services'
      throw err
    } finally {
      loading.value = false
    }
  }

  /**
   * Get a single service by ID
   */
  const getService = (serviceId) => {
    return services.value.find(s => s.id === serviceId)
  }

  return {
    services,
    loading,
    error,
    fetchServices,
    getService
  }
}
