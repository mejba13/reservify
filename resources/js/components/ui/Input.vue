<template>
  <div class="w-full">
    <label
      v-if="label"
      :for="id"
      class="block text-sm font-medium text-[#0A0A0A] mb-2"
    >
      {{ label }}
      <span v-if="required" class="text-[#DC2626]">*</span>
    </label>

    <div class="relative">
      <input
        :id="id"
        :type="type"
        :value="modelValue"
        :placeholder="placeholder"
        :required="required"
        :disabled="disabled"
        :readonly="readonly"
        :autocomplete="autocomplete"
        :class="inputClasses"
        @input="handleInput"
        @blur="handleBlur"
        @focus="handleFocus"
      />

      <div v-if="$slots.icon" class="absolute left-3 top-1/2 -translate-y-1/2 text-[#A3A3A3]">
        <slot name="icon" />
      </div>
    </div>

    <p v-if="error" class="mt-2 text-sm text-[#DC2626]">
      {{ error }}
    </p>

    <p v-else-if="hint" class="mt-2 text-sm text-[#525252]">
      {{ hint }}
    </p>
  </div>
</template>

<script setup>
import { computed, ref } from 'vue'

const props = defineProps({
  id: {
    type: String,
    default: () => `input-${Math.random().toString(36).substr(2, 9)}`
  },
  modelValue: [String, Number],
  type: {
    type: String,
    default: 'text'
  },
  label: String,
  placeholder: String,
  error: String,
  hint: String,
  required: Boolean,
  disabled: Boolean,
  readonly: Boolean,
  autocomplete: String
})

const emit = defineEmits(['update:modelValue', 'blur', 'focus'])

const isFocused = ref(false)

const handleInput = (event) => {
  emit('update:modelValue', event.target.value)
}

const handleBlur = (event) => {
  isFocused.value = false
  emit('blur', event)
}

const handleFocus = (event) => {
  isFocused.value = true
  emit('focus', event)
}

const inputClasses = computed(() => {
  const classes = [
    'w-full',
    'px-4',
    'py-3',
    'text-base',
    'text-[#0A0A0A]',
    'bg-white',
    'border-2',
    'rounded-lg',
    'transition-all',
    'duration-150',
    'placeholder:text-[#A3A3A3]'
  ]

  // Icon padding
  if (this.$slots.icon) {
    classes.push('pl-10')
  }

  // State-based styles
  if (props.error) {
    classes.push('border-[#DC2626]', 'focus:ring-[#DC2626]/20')
  } else if (isFocused.value) {
    classes.push('border-[#2563EB]', 'ring-4', 'ring-[#2563EB]/10')
  } else {
    classes.push('border-[#E5E5E5]', 'hover:border-[#D4D4D4]')
  }

  // Disabled state
  if (props.disabled) {
    classes.push('bg-[#F5F5F5]', 'cursor-not-allowed', 'opacity-60')
  }

  // Readonly state
  if (props.readonly) {
    classes.push('bg-[#FAFAFA]')
  }

  return classes
})
</script>
