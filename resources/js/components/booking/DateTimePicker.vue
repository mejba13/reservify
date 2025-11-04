<template>
  <div>
    <h2 class="text-xl sm:text-2xl font-semibold text-[#0A0A0A] mb-2">Select Date & Time</h2>
    <p class="text-sm sm:text-base text-[#525252] mb-6">Choose when you'd like your appointment</p>

    <!-- Date Selection -->
    <div class="mb-6">
      <label class="block text-sm font-medium text-[#0A0A0A] mb-2">
        Select Date
      </label>
      <Input
        v-model="selectedDate"
        type="date"
        :min="minDate"
        @input="handleDateChange"
      />
    </div>

    <!-- Time Slots -->
    <div v-if="selectedDate">
      <label class="block text-sm font-medium text-[#0A0A0A] mb-3">
        Available Time Slots
      </label>

      <!-- Loading State -->
      <div v-if="loading" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 sm:gap-3">
        <div v-for="i in 8" :key="i" class="h-10 sm:h-12 bg-[#F5F5F5] animate-pulse rounded-lg"></div>
      </div>

      <!-- Available Slots -->
      <div v-else-if="availableSlots.length > 0" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2 sm:gap-3">
        <button
          v-for="slot in availableSlots"
          :key="slot.start_time"
          @click="selectTimeSlot(slot)"
          :class="[
            'px-3 sm:px-4 py-2 sm:py-3 rounded-lg border-2 transition-all duration-150 text-sm sm:text-base',
            'hover:border-[#2563EB] hover:bg-[#2563EB]/5',
            'focus:outline-none focus:ring-2 focus:ring-[#2563EB]/40',
            selectedSlot?.start_time === slot.start_time
              ? 'border-[#2563EB] bg-[#2563EB] text-white font-medium'
              : 'border-[#E5E5E5] bg-white text-[#0A0A0A]'
          ]"
        >
          {{ formatTime(slot.start_time) }}
        </button>
      </div>

      <!-- No Slots Available -->
      <div v-else class="text-center py-8">
        <p class="text-[#525252]">No available time slots for this date.</p>
        <p class="text-sm text-[#A3A3A3] mt-2">Please try another date.</p>
      </div>
    </div>

    <!-- Prompt to select date -->
    <div v-else class="text-center py-8 sm:py-12 bg-[#F5F5F5] rounded-xl">
      <p class="text-sm sm:text-base text-[#525252] px-4">Please select a date to view available times</p>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { useAvailability } from '@/composables/useAvailability'
import Input from '@/components/ui/Input.vue'

const props = defineProps({
  modelValue: Object,
  providerId: [Number, String],
  serviceId: [Number, String]
})

const emit = defineEmits(['update:modelValue'])

const { availableSlots, loading, fetchAvailableSlots, clearSlots } = useAvailability()

const selectedDate = ref('')
const selectedSlot = ref(null)

// Set minimum date to today
const minDate = computed(() => {
  return new Date().toISOString().split('T')[0]
})

// Watch for service/provider changes
watch([() => props.serviceId, () => props.providerId], () => {
  selectedDate.value = ''
  selectedSlot.value = null
  clearSlots()
})

const handleDateChange = async () => {
  selectedSlot.value = null
  clearSlots()

  if (selectedDate.value && props.providerId && props.serviceId) {
    try {
      await fetchAvailableSlots(props.providerId, props.serviceId, selectedDate.value)
    } catch (err) {
      console.error('Failed to fetch slots:', err)
    }
  }
}

const selectTimeSlot = (slot) => {
  selectedSlot.value = slot
  emit('update:modelValue', {
    date: selectedDate.value,
    slot: slot
  })
}

const formatTime = (isoString) => {
  const date = new Date(isoString)
  return date.toLocaleTimeString('en-US', {
    hour: 'numeric',
    minute: '2-digit',
    hour12: true
  })
}
</script>
