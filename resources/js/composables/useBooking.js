import { ref } from 'vue'
import api from '@/utils/api'

/**
 * Booking Composable
 *
 * Manages booking state and API interactions
 */
export function useBooking() {
  const bookings = ref([])
  const loading = ref(false)
  const error = ref(null)

  /**
   * Fetch customer bookings
   */
  const fetchBookings = async () => {
    loading.value = true
    error.value = null

    try {
      const response = await api.get('/customer/bookings')
      bookings.value = response.data.data
      return bookings.value
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to fetch bookings'
      throw err
    } finally {
      loading.value = false
    }
  }

  /**
   * Create a new booking
   */
  const createBooking = async (bookingData) => {
    loading.value = true
    error.value = null

    try {
      const response = await api.post('/bookings', bookingData)
      return response.data.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to create booking'
      throw err
    } finally {
      loading.value = false
    }
  }

  /**
   * Cancel a booking
   */
  const cancelBooking = async (bookingId, reason) => {
    loading.value = true
    error.value = null

    try {
      const response = await api.post(`/bookings/${bookingId}/cancel`, {
        cancellation_reason: reason
      })

      // Update local bookings list
      const index = bookings.value.findIndex(b => b.id === bookingId)
      if (index !== -1) {
        bookings.value[index] = response.data.data
      }

      return response.data.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to cancel booking'
      throw err
    } finally {
      loading.value = false
    }
  }

  /**
   * Reschedule a booking
   */
  const rescheduleBooking = async (bookingId, newStartTime) => {
    loading.value = true
    error.value = null

    try {
      const response = await api.post(`/bookings/${bookingId}/reschedule`, {
        new_start_time: newStartTime
      })

      // Update local bookings list
      const index = bookings.value.findIndex(b => b.id === bookingId)
      if (index !== -1) {
        bookings.value[index] = response.data.data
      }

      return response.data.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to reschedule booking'
      throw err
    } finally {
      loading.value = false
    }
  }

  return {
    bookings,
    loading,
    error,
    fetchBookings,
    createBooking,
    cancelBooking,
    rescheduleBooking
  }
}
