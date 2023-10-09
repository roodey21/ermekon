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
    </div>
</template>
