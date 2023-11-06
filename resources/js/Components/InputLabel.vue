<script setup>
defineProps({
    value: {
        type: String,
    },
    required: {
        type: Boolean,
        default: false,
    },
});
</script>

<template>
    <label class="block mb-1 text-sm font-medium text-gray-700 after:content-['*'] after:invisible" :class="{ 'after:!visible after:text-red-600' : required }">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
