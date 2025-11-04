<template>
  <div :class="cardClasses">
    <div v-if="$slots.header || title" class="card-header border-b border-[#E5E5E5] pb-4 mb-6">
      <slot name="header">
        <h3 v-if="title" class="text-2xl font-medium text-[#0A0A0A]">
          {{ title }}
        </h3>
        <p v-if="subtitle" class="mt-1 text-[#525252]">
          {{ subtitle }}
        </p>
      </slot>
    </div>

    <div class="card-body">
      <slot />
    </div>

    <div v-if="$slots.footer" class="card-footer border-t border-[#E5E5E5] pt-4 mt-6">
      <slot name="footer" />
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  title: String,
  subtitle: String,
  padding: {
    type: String,
    default: 'lg',
    validator: (value) => ['sm', 'md', 'lg', 'xl', 'none'].includes(value)
  },
  hover: Boolean,
  clickable: Boolean
})

const cardClasses = computed(() => {
  const classes = [
    'bg-white',
    'border',
    'border-[#E5E5E5]',
    'rounded-xl'
  ]

  // Padding
  const paddingMap = {
    none: '',
    sm: 'p-4',
    md: 'p-6',
    lg: 'p-6',
    xl: 'p-8'
  }
  if (props.padding !== 'none') {
    classes.push(paddingMap[props.padding])
  }

  // Hover effect
  if (props.hover) {
    classes.push(
      'card-hover',
      'transition-all',
      'duration-200',
      'ease-out',
      'hover:shadow-md',
      'hover:border-[#D4D4D4]'
    )
  }

  // Clickable
  if (props.clickable) {
    classes.push('cursor-pointer')
  }

  return classes
})
</script>
