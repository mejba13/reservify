import { ref } from 'vue'
import api from '@/utils/api'

/**
 * Availability Composable
 *
 * Manages availability checks and time slot fetching
 */
export function useAvailability() {
  const availableSlots = ref([])
  const loading = ref(false)
  const error = ref(null)

  /**
   * Fetch available time slots for a specific date
   */
  const fetchAvailableSlots = async (providerId, serviceId, date) => {
    loading.value = true
    error.value = null

    try {
      const response = await api.get('/availability', {
        params: {
          provider_id: providerId,
          service_id: serviceId,
          date: date
        }
      })

      availableSlots.value = response.data.available_slots
      return availableSlots.value
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to fetch available slots'
      availableSlots.value = []
      throw err
    } finally {
      loading.value = false
    }
  }

  /**
   * Clear available slots
   */
  const clearSlots = () => {
    availableSlots.value = []
  }

  return {
    availableSlots,
    loading,
    error,
    fetchAvailableSlots,
    clearSlots
  }
}
