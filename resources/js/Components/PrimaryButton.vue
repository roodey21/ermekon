<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-widest text-white transition duration-150 ease-in-out border border-transparent bg-teal-700 hover:bg-teal-900 focus:bg-teal-900 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:bg-teal-900/60 disabled:cursor-not-allowed"
    >
        <slot />
    </button>
</template>
