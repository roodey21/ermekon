<script setup>
import { computed } from 'vue';

const props = defineProps({
    text: {
        type: String,
        required: true,
    },
    position: {
        type: String,
        default: 'top'
    }
})

const tooltipPositionClass = computed(() => ({
    'tooltip__text': true,
    [`tooltip--${props.position}`]: true
}))
</script>

<template>
    <div class="relative inline-block group">
        <slot />
        <span
            :class="tooltipPositionClass"
            class="toooltip__text invisible opacity-0 transition-opacity duration-500 text-[10px] text-white text-center rounded px-1 py-0.5 min-w-[120px] group-hover:visible group-hover:opacity-100 absolute z-[1] bg-[#111827]">
            {{ text }}
        </span>
    </div>
</template>

<style>
:slotted(*):focus+.tooltip__text {
    visibility: visible;
    opacity: 1;
}
.tooltip--top {
    inset-block-end: 140%;
    inset-inline-start: 50%;
    margin-inline-start: -60px;
}
.tooltip--bottom {
    inset-block-start: 140%;
    inset-inline-start: 50%;
    margin-inline-start: -60px;
}
.tooltip--left {
    inset-block-end: 0%;
    inset-inline-end: 130%;
}
.tooltip--right {
    inset-block-end: 0%;
    inset-inline-start: 130%;
}
.tooltip__text::after {
    content: " ";
    position: absolute;
    border-width: 5px;
    border-style: solid;
}
.tooltip--left::after {
    inset-block-start: 50%;
    inset-inline-start: 100%;
    border-color: transparent transparent transparent #111827;
}

.tooltip--right::after {
    inset-block-start: 50%;
    inset-inline-end: 100%;
    border-color: transparent #111827 transparent transparent;
}

.tooltip--top::after {
    inset-block-start: 100%;
    inset-inline-start: 50%;
    border-color: #111827 transparent transparent  transparent;
}

.tooltip--bottom::after {
    inset-block-end: 100%;
    inset-inline-start: 50%;
    border-color: transparent transparent #111827 transparent;
}
</style>
