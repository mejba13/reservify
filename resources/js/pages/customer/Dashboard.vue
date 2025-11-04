<template>
  <div class="min-h-screen bg-[#FAFAFA]">
    <!-- Header -->
    <div class="bg-white border-b border-[#E5E5E5]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 sm:py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
          <div>
            <h1 class="text-2xl sm:text-3xl font-semibold text-[#0A0A0A]">My Bookings</h1>
            <p class="text-sm sm:text-base text-[#525252] mt-1">Manage your appointments</p>
          </div>
          <Button variant="primary" @click="$router.push('/booking')" class="w-full sm:w-auto">
            New Booking
          </Button>
        </div>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
      <!-- Loading State -->
      <div v-if="loading" class="space-y-3 sm:space-y-4">
        <div v-for="i in 3" :key="i" class="h-32 bg-white animate-pulse rounded-xl"></div>
      </div>

      <!-- Bookings List -->
      <div v-else-if="bookings.length > 0" class="space-y-3 sm:space-y-4">
        <Card
          v-for="booking in bookings"
          :key="booking.id"
          padding="lg"
          hover
          class="transition-all duration-200"
        >
          <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <!-- Booking Info -->
            <div class="flex-1 min-w-0">
              <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-3">
                <span
                  :class="[
                    'px-2 sm:px-3 py-1 text-xs font-medium rounded-full whitespace-nowrap',
                    getStatusColor(booking.status)
                  ]"
                >
                  {{ formatStatus(booking.status) }}
                </span>
                <span class="text-xs sm:text-sm text-[#525252] truncate">
                  Booking #{{ booking.uuid.slice(0, 8) }}
                </span>
              </div>

              <h3 class="text-base sm:text-lg font-semibold text-[#0A0A0A] mb-2">
                {{ booking.service.name }}
              </h3>

              <div class="space-y-1 text-xs sm:text-sm text-[#525252]">
                <div class="flex items-center gap-2">
                  <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                  <span class="truncate">{{ formatDate(booking.start_time) }}</span>
                </div>
                <div class="flex items-center gap-2">
                  <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  <span>{{ formatTime(booking.start_time) }} ({{ booking.service.duration_minutes }} min)</span>
                </div>
                <div class="flex items-center gap-2">
                  <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                  </svg>
                  <span class="truncate">{{ booking.provider.name }}</span>
                </div>
              </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-wrap sm:flex-col gap-2">
              <Button
                v-if="booking.can_be_cancelled"
                variant="ghost"
                size="sm"
                @click="openCancelModal(booking)"
                class="flex-1 sm:flex-none"
              >
                Cancel
              </Button>
              <Button
                v-if="booking.can_be_rescheduled"
                variant="secondary"
                size="sm"
                @click="openRescheduleModal(booking)"
                class="flex-1 sm:flex-none"
              >
                Reschedule
              </Button>
              <Button
                variant="ghost"
                size="sm"
                @click="selectedBooking = booking"
                class="flex-1 sm:flex-none"
              >
                Details
              </Button>
            </div>
          </div>

          <!-- Notes -->
          <div v-if="booking.notes" class="mt-4 pt-4 border-t border-[#E5E5E5]">
            <p class="text-sm text-[#525252]">
              <span class="font-medium">Notes:</span> {{ booking.notes }}
            </p>
          </div>
        </Card>
      </div>

      <!-- Empty State -->
      <div v-else class="text-center py-12 sm:py-16">
        <div class="w-16 sm:w-20 h-16 sm:h-20 bg-[#F5F5F5] rounded-full flex items-center justify-center mx-auto mb-4">
          <svg class="w-8 sm:w-10 h-8 sm:h-10 text-[#A3A3A3]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
        </div>
        <h3 class="text-lg sm:text-xl font-semibold text-[#0A0A0A] mb-2 px-4">No bookings yet</h3>
        <p class="text-sm sm:text-base text-[#525252] mb-6 px-4">Start by creating your first appointment</p>
        <Button variant="primary" @click="$router.push('/booking')" class="w-full sm:w-auto mx-4 sm:mx-0">
          Book Now
        </Button>
      </div>
    </div>

    <!-- Cancel Modal -->
    <Modal v-model="showCancelModal" title="Cancel Booking" size="md">
      <div class="space-y-4">
        <p class="text-[#525252]">Are you sure you want to cancel this booking?</p>

        <Input
          v-model="cancellationReason"
          type="textarea"
          label="Reason for cancellation"
          placeholder="Please tell us why you're cancelling..."
          required
        />

        <div v-if="cancelError" class="p-4 bg-[#DC2626]/10 border border-[#DC2626] rounded-lg">
          <p class="text-sm text-[#DC2626]">{{ cancelError }}</p>
        </div>
      </div>

      <template #footer>
        <div class="flex gap-3 justify-end">
          <Button variant="ghost" @click="closeCancelModal">
            Keep Booking
          </Button>
          <Button
            variant="danger"
            :loading="cancelLoading"
            :disabled="!cancellationReason || cancelLoading"
            @click="confirmCancel"
          >
            Cancel Booking
          </Button>
        </div>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useBooking } from '@/composables/useBooking'
import Button from '@/components/ui/Button.vue'
import Card from '@/components/ui/Card.vue'
import Modal from '@/components/ui/Modal.vue'
import Input from '@/components/ui/Input.vue'

const { bookings, loading, fetchBookings, cancelBooking } = useBooking()

const selectedBooking = ref(null)
const showCancelModal = ref(false)
const bookingToCancel = ref(null)
const cancellationReason = ref('')
const cancelError = ref('')
const cancelLoading = ref(false)

onMounted(async () => {
  await fetchBookings()
})

const getStatusColor = (status) => {
  const colors = {
    pending: 'bg-[#D97706]/10 text-[#D97706]',
    confirmed: 'bg-[#2563EB]/10 text-[#2563EB]',
    completed: 'bg-[#059669]/10 text-[#059669]',
    cancelled: 'bg-[#DC2626]/10 text-[#DC2626]',
    no_show: 'bg-[#A3A3A3]/10 text-[#A3A3A3]'
  }
  return colors[status] || 'bg-[#F5F5F5] text-[#525252]'
}

const formatStatus = (status) => {
  return status.charAt(0).toUpperCase() + status.slice(1).replace('_', ' ')
}

const formatDate = (isoString) => {
  return new Date(isoString).toLocaleDateString('en-US', {
    weekday: 'short',
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const formatTime = (isoString) => {
  return new Date(isoString).toLocaleTimeString('en-US', {
    hour: 'numeric',
    minute: '2-digit',
    hour12: true
  })
}

const openCancelModal = (booking) => {
  bookingToCancel.value = booking
  cancellationReason.value = ''
  cancelError.value = ''
  showCancelModal.value = true
}

const closeCancelModal = () => {
  showCancelModal.value = false
  bookingToCancel.value = null
  cancellationReason.value = ''
  cancelError.value = ''
}

const confirmCancel = async () => {
  if (!cancellationReason.value) return

  cancelLoading.value = true
  cancelError.value = ''

  try {
    await cancelBooking(bookingToCancel.value.id, cancellationReason.value)
    closeCancelModal()
  } catch (err) {
    cancelError.value = err.response?.data?.message || 'Failed to cancel booking'
  } finally {
    cancelLoading.value = false
  }
}

const openRescheduleModal = (booking) => {
  // TODO: Implement reschedule modal
  alert('Reschedule functionality coming soon!')
}
</script>
