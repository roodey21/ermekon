<script setup>
defineProps({
    task: {
        type: Object,
        default: () => []
    }
})
</script>
<template>
    <div class="flex pl-16 pr-8 border-b border-gray-200 group hover:bg-gray-100 hover:cursor-pointer table-header">
        <div class="flex py-3 grow">
            <div class="text-sm font-medium">
                {{ task.name }}
            </div>
        </div>
        <div class="flex items-center">
            <div class="w-40 py-2">
                <div class="text-xs font-light text-center">
                    Pembelian Site
                </div>
            </div>
            <div class="w-40 py-2">
                <div class="text-xs font-light text-center">
                    5
                </div>
            </div>
            <div class="w-40 py-2">
                <div class="text-xs font-light text-center">
                    m
                </div>
            </div>
        </div>
    </div>
</template>
