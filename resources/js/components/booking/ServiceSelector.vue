<template>
  <div>
    <h2 class="text-xl sm:text-2xl font-semibold text-[#0A0A0A] mb-2">Select a Service</h2>
    <p class="text-sm sm:text-base text-[#525252] mb-6">Choose the service you'd like to book</p>

    <!-- Loading State -->
    <div v-if="loading" class="grid gap-4">
      <div v-for="i in 3" :key="i" class="h-32 bg-[#F5F5F5] animate-pulse rounded-xl"></div>
    </div>

    <!-- Services Grid -->
    <div v-else-if="services.length > 0" class="grid gap-4">
      <Card
        v-for="service in services"
        :key="service.id"
        padding="lg"
        hover
        clickable
        @click="selectService(service)"
        :class="{ 'border-[#2563EB] border-2': modelValue?.id === service.id }"
      >
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 sm:gap-4">
          <div class="flex-1 min-w-0">
            <h3 class="text-base sm:text-lg font-medium text-[#0A0A0A] mb-1">
              {{ service.name }}
            </h3>
            <p class="text-xs sm:text-sm text-[#525252] mb-3 line-clamp-2">
              {{ service.description }}
            </p>
            <div class="flex items-center gap-3 sm:gap-4 text-xs sm:text-sm text-[#525252]">
              <span class="flex items-center gap-1">
                <svg class="w-3 h-3 sm:w-4 sm:h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ service.duration_minutes }} min
              </span>
            </div>
          </div>
          <div class="text-left sm:text-right flex-shrink-0">
            <div class="text-xl sm:text-2xl font-semibold text-[#0A0A0A]">
              ${{ service.price }}
            </div>
            <div v-if="service.requires_deposit" class="text-xs text-[#525252] mt-1">
              ${{ service.deposit_amount }} deposit
            </div>
          </div>
        </div>

        <!-- Selected Indicator -->
        <div v-if="modelValue?.id === service.id" class="mt-4 pt-4 border-t border-[#E5E5E5]">
          <div class="flex items-center gap-2 text-[#2563EB] text-sm font-medium">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            Selected
          </div>
        </div>
      </Card>
    </div>

    <!-- Empty State -->
    <div v-else class="text-center py-12">
      <p class="text-[#525252]">No services available at the moment.</p>
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { useServices } from '@/composables/useServices'
import Card from '@/components/ui/Card.vue'

const props = defineProps({
  modelValue: Object
})

const emit = defineEmits(['update:modelValue'])

const { services, loading, fetchServices } = useServices()

onMounted(async () => {
  await fetchServices()
})

const selectService = (service) => {
  emit('update:modelValue', service)
}
</script>
