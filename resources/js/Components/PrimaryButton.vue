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
        class="inline-flex items-center px-3 py-1.5 text-xs font-semibold tracking-widest text-white transition duration-150 ease-in-out border border-transparent bg-stone-700 hover:bg-stone-900 focus:bg-stone-900 active:bg-stone-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
    >
        <slot />
    </button>
</template>
