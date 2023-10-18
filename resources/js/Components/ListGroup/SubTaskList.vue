<script setup>
const props = defineProps({
    task: {
        type: Object,
        default: () => []
    }
})

const emit = defineEmits(['editTask'])

const editTask = () => {
    emit('editTask', [props.task.id])
}
</script>
<template>
    <div class="flex pl-16 pr-8 border-b border-gray-200 group hover:bg-gray-100 hover:cursor-pointer table-header" @click="editTask">
        <div class="flex py-3 grow">
            <div class="text-sm font-medium">
                {{ task.name }}
            </div>
        </div>
    </div>
</template>
