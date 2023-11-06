<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    placeholder: {
        type: String,
        required: false,
    },
    withBorder: {
        type: Boolean,
        required: false,
        default: false,
    }
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <!-- <input
        class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        ref="input"
    /> -->
    <input
        class="w-full p-2 text-sm font-light text-gray-900 border border-gray-200 rounded placeholder:text-gray-400 focus:ring-0 focus:border-gray-400"
        :class="{'border-opacity-0 hover:border-opacity-100': !withBorder}"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :placeholder="placeholder"
        ref="input" />
</template>
