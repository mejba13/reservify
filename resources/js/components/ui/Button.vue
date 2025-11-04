<template>
  <component
    :is="tag"
    :type="tag === 'button' ? type : undefined"
    :disabled="disabled || loading"
    :class="buttonClasses"
    @click="handleClick"
  >
    <span v-if="loading" class="mr-2">
      <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
    </span>
    <slot />
  </component>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'primary',
    validator: (value) => ['primary', 'secondary', 'ghost', 'danger'].includes(value)
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg'].includes(value)
  },
  tag: {
    type: String,
    default: 'button'
  },
  type: {
    type: String,
    default: 'button'
  },
  disabled: Boolean,
  loading: Boolean,
  fullWidth: Boolean
})

const emit = defineEmits(['click'])

const handleClick = (event) => {
  if (!props.disabled && !props.loading) {
    emit('click', event)
  }
}

const buttonClasses = computed(() => {
  const classes = ['button-lift', 'font-medium', 'rounded-lg', 'transition-all', 'duration-150', 'ease-in-out']

  // Variant styles
  const variantStyles = {
    primary: [
      'bg-[#2563EB]',
      'text-white',
      'hover:bg-[#1D4ED8]',
      'active:bg-[#1E40AF]',
      'focus-visible:ring-2',
      'focus-visible:ring-[#2563EB]/40',
      'focus-visible:ring-offset-2'
    ],
    secondary: [
      'bg-transparent',
      'border-2',
      'border-[#D4D4D4]',
      'text-[#0A0A0A]',
      'hover:border-[#A3A3A3]',
      'hover:bg-[#FAFAFA]'
    ],
    ghost: [
      'bg-transparent',
      'text-[#525252]',
      'hover:text-[#0A0A0A]',
      'hover:bg-[#F5F5F5]'
    ],
    danger: [
      'bg-[#DC2626]',
      'text-white',
      'hover:bg-[#B91C1C]',
      'active:bg-[#991B1B]'
    ]
  }

  // Size styles
  const sizeStyles = {
    sm: ['px-4', 'py-2', 'text-sm'],
    md: ['px-6', 'py-3', 'text-base'],
    lg: ['px-8', 'py-4', 'text-lg']
  }

  // Disabled state
  if (props.disabled || props.loading) {
    classes.push('opacity-50', 'cursor-not-allowed')
  }

  // Full width
  if (props.fullWidth) {
    classes.push('w-full')
  }

  return [
    ...classes,
    ...variantStyles[props.variant],
    ...sizeStyles[props.size]
  ]
})
</script>

<style scoped>
.button-lift:hover:not(:disabled) {
  transform: translateY(-1px);
}

.button-lift:active:not(:disabled) {
  transform: translateY(0);
}
</style>
