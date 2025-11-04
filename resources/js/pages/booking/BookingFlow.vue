<template>
  <div class="min-h-screen bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
      <!-- Progress Steps -->
      <div class="mb-8 sm:mb-12">
        <div class="flex items-center justify-center gap-2 sm:gap-4 overflow-x-auto pb-4">
          <div
            v-for="(step, index) in steps"
            :key="index"
            class="flex items-center"
          >
            <!-- Step Circle -->
            <div class="flex flex-col items-center min-w-[80px] sm:min-w-[100px]">
              <div
                :class="[
                  'w-10 h-10 sm:w-12 sm:h-12 rounded-full flex items-center justify-center font-medium transition-all duration-200 text-sm sm:text-base',
                  currentStep > index
                    ? 'bg-[#059669] text-white'
                    : currentStep === index
                    ? 'bg-[#2563EB] text-white'
                    : 'bg-[#F5F5F5] text-[#A3A3A3]'
                ]"
              >
                <svg v-if="currentStep > index" class="w-5 h-5 sm:w-6 sm:h-6" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                <span v-else>{{ index + 1 }}</span>
              </div>
              <span class="mt-2 text-xs sm:text-sm font-medium text-center" :class="currentStep >= index ? 'text-[#0A0A0A]' : 'text-[#A3A3A3]'">
                {{ step }}
              </span>
            </div>

            <!-- Connector Line -->
            <div
              v-if="index < steps.length - 1"
              :class="[
                'w-12 sm:w-24 h-1 mx-2 sm:mx-4 transition-all duration-200 flex-shrink-0',
                currentStep > index ? 'bg-[#059669]' : 'bg-[#E5E5E5]'
              ]"
            />
          </div>
        </div>
      </div>

      <!-- Step Content -->
      <div class="bg-white rounded-2xl border border-[#E5E5E5] p-4 sm:p-6 md:p-8">
        <!-- Step 1: Select Service -->
        <div v-if="currentStep === 0">
          <ServiceSelector v-model="selectedService" />
        </div>

        <!-- Step 2: Select Date & Time -->
        <div v-if="currentStep === 1">
          <DateTimePicker
            v-model="selectedDateTime"
            :provider-id="1"
            :service-id="selectedService?.id"
          />
        </div>

        <!-- Step 3: Booking Details -->
        <div v-if="currentStep === 2">
          <h2 class="text-xl sm:text-2xl font-semibold text-[#0A0A0A] mb-2">Booking Details</h2>
          <p class="text-sm sm:text-base text-[#525252] mb-6">Add any additional notes for your appointment</p>

          <Input
            v-model="bookingNotes"
            type="textarea"
            label="Notes (Optional)"
            placeholder="Any special requests or information..."
            :error="errors.notes"
          />
        </div>

        <!-- Step 4: Confirmation -->
        <div v-if="currentStep === 3">
          <h2 class="text-xl sm:text-2xl font-semibold text-[#0A0A0A] mb-2">Review & Confirm</h2>
          <p class="text-sm sm:text-base text-[#525252] mb-6">Please review your booking details</p>

          <Card padding="lg" class="mb-6">
            <div class="space-y-4">
              <div>
                <h3 class="text-xs sm:text-sm font-medium text-[#525252] mb-1">Service</h3>
                <p class="text-base sm:text-lg font-medium text-[#0A0A0A]">{{ selectedService?.name }}</p>
                <p class="text-xs sm:text-sm text-[#525252]">{{ selectedService?.duration_minutes }} minutes</p>
              </div>

              <div class="border-t border-[#E5E5E5] pt-4">
                <h3 class="text-xs sm:text-sm font-medium text-[#525252] mb-1">Date & Time</h3>
                <p class="text-base sm:text-lg font-medium text-[#0A0A0A]">
                  {{ formatDate(selectedDateTime?.date) }}
                </p>
                <p class="text-xs sm:text-sm text-[#525252]">
                  {{ formatTime(selectedDateTime?.slot?.start_time) }}
                </p>
              </div>

              <div v-if="bookingNotes" class="border-t border-[#E5E5E5] pt-4">
                <h3 class="text-xs sm:text-sm font-medium text-[#525252] mb-1">Notes</h3>
                <p class="text-xs sm:text-sm text-[#0A0A0A]">{{ bookingNotes }}</p>
              </div>

              <div class="border-t border-[#E5E5E5] pt-4">
                <h3 class="text-xs sm:text-sm font-medium text-[#525252] mb-1">Total</h3>
                <p class="text-xl sm:text-2xl font-semibold text-[#0A0A0A]">${{ selectedService?.price }}</p>
                <p v-if="selectedService?.requires_deposit" class="text-xs sm:text-sm text-[#525252]">
                  ${{ selectedService?.deposit_amount }} deposit required
                </p>
              </div>
            </div>
          </Card>

          <!-- Error Message -->
          <div v-if="bookingError" class="mb-6 p-4 bg-[#DC2626]/10 border border-[#DC2626] rounded-lg">
            <p class="text-sm text-[#DC2626]">{{ bookingError }}</p>
          </div>
        </div>

        <!-- Success Message -->
        <div v-if="bookingSuccess" class="text-center py-8 sm:py-12">
          <div class="w-16 h-16 sm:w-20 sm:h-20 bg-[#059669] rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8 sm:w-10 sm:h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
          </div>
          <h2 class="text-2xl sm:text-3xl font-semibold text-[#0A0A0A] mb-2 px-4">Booking Confirmed!</h2>
          <p class="text-sm sm:text-base text-[#525252] mb-6 sm:mb-8 px-4">Your appointment has been successfully booked.</p>

          <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center px-4">
            <Button variant="primary" @click="goToDashboard" class="w-full sm:w-auto">
              View My Bookings
            </Button>
            <Button variant="secondary" @click="resetBooking" class="w-full sm:w-auto">
              Book Another
            </Button>
          </div>
        </div>

        <!-- Navigation Buttons -->
        <div v-if="!bookingSuccess" class="flex flex-col-reverse sm:flex-row justify-between gap-3 mt-6 sm:mt-8 pt-4 sm:pt-6 border-t border-[#E5E5E5]">
          <Button
            v-if="currentStep > 0"
            variant="ghost"
            @click="previousStep"
            class="w-full sm:w-auto"
          >
            Back
          </Button>
          <div v-else class="hidden sm:block"></div>

          <Button
            v-if="currentStep < 3"
            variant="primary"
            @click="nextStep"
            :disabled="!canProceed"
            class="w-full sm:w-auto"
          >
            Continue
          </Button>

          <Button
            v-else
            variant="primary"
            @click="confirmBooking"
            :loading="loading"
            :disabled="loading"
            class="w-full sm:w-auto"
          >
            Confirm Booking
          </Button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useBooking } from '@/composables/useBooking'
import ServiceSelector from '@/components/booking/ServiceSelector.vue'
import DateTimePicker from '@/components/booking/DateTimePicker.vue'
import Button from '@/components/ui/Button.vue'
import Card from '@/components/ui/Card.vue'
import Input from '@/components/ui/Input.vue'

const router = useRouter()
const { createBooking } = useBooking()

const steps = ['Service', 'Date & Time', 'Details', 'Confirm']
const currentStep = ref(0)

const selectedService = ref(null)
const selectedDateTime = ref(null)
const bookingNotes = ref('')
const errors = ref({})
const bookingError = ref('')
const bookingSuccess = ref(false)
const loading = ref(false)

const canProceed = computed(() => {
  if (currentStep.value === 0) return !!selectedService.value
  if (currentStep.value === 1) return !!selectedDateTime.value?.slot
  if (currentStep.value === 2) return true
  return false
})

const nextStep = () => {
  if (canProceed.value && currentStep.value < 3) {
    currentStep.value++
  }
}

const previousStep = () => {
  if (currentStep.value > 0) {
    currentStep.value--
  }
}

const confirmBooking = async () => {
  bookingError.value = ''
  loading.value = true

  try {
    await createBooking({
      service_id: selectedService.value.id,
      provider_id: 1, // TODO: Get from provider selection
      start_time: selectedDateTime.value.slot.start_time,
      notes: bookingNotes.value || null
    })

    bookingSuccess.value = true
  } catch (err) {
    bookingError.value = err.response?.data?.message || 'Failed to create booking. Please try again.'
  } finally {
    loading.value = false
  }
}

const formatDate = (dateString) => {
  if (!dateString) return ''
  return new Date(dateString).toLocaleDateString('en-US', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

const formatTime = (isoString) => {
  if (!isoString) return ''
  return new Date(isoString).toLocaleTimeString('en-US', {
    hour: 'numeric',
    minute: '2-digit',
    hour12: true
  })
}

const goToDashboard = () => {
  router.push('/dashboard')
}

const resetBooking = () => {
  currentStep.value = 0
  selectedService.value = null
  selectedDateTime.value = null
  bookingNotes.value = ''
  bookingSuccess.value = false
  bookingError.value = ''
}
</script>
