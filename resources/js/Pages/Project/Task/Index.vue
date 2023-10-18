<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { PlusIcon } from '@heroicons/vue/24/outline';
import { computed, ref } from 'vue';
import draggable from 'vuedraggable';

defineProps({
    props: {
        project: {
            type: Object,
            required: true,
        },
        tasks: {
            type: Object,
            required: true,
        }
    }
})

const list1 = ref([
    { id: 1, name: 'Task 1'},
    { id: 2, name: 'Task 2'},
    { id: 3, name: 'Task 3'},
    { id: 4, name: 'Task 4'},
    { id: 5, name: 'Task 5'},
])

const list2 = ref([
    { id: 1, name: 'Task 1'},
    { id: 2, name: 'Task 2'},
    { id: 3, name: 'Task 3'},
    { id: 4, name: 'Task 4'},
    { id: 5, name: 'Task 5'},
])

const dropOptions = computed(() => ({
    animation: 200,
    group: 'task',
}))

defineOptions({
    layout: AuthenticatedLayout
})
</script>

<template>
    <div class="p-4 w-[calc(100vw-4rem)]">
        <div class="p-4 overflow-x-auto">
            <div class="flex flex-row gap-6 flex-nowrap ">
                <div class="flex-none bg-white border rounded-lg shadow w-80 h-min">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h6 class="text-base font-medium text-gray-800">
                            To Do
                        </h6>
                        <div>
                            <button class="p-1 bg-teal-700 border rounded">
                                <PlusIcon class="w-4 h-4 text-white" />
                            </button>
                        </div>
                    </div>
                    <draggable class="p-4 space-y-2"
                        :list="list1"
                        itemKey="name"
                        group="task"
                        v-bind="dropOptions">
                        <template #item="{ element }">
                            <div class="p-4 bg-white border rounded-lg shadow">
                                <span class="text-sm select-none">{{ element.name }}</span>
                            </div>
                        </template>
                    </draggable>
                </div>
                <div class="flex-none bg-white border rounded-lg shadow w-80 h-min">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h6 class="text-base font-medium text-gray-800">
                            In Progress
                        </h6>
                        <div>
                            <button class="p-1 bg-teal-700 border rounded">
                                <PlusIcon class="w-4 h-4 text-white" />
                            </button>
                        </div>
                    </div>
                    <draggable class="p-4 space-y-2"
                        :list="list2"
                        itemKey="name"
                        group="task"
                        v-bind="dropOptions">
                        <template #item="{ element }">
                            <div class="p-4 bg-white border rounded-lg shadow">
                                <span class="text-sm select-none">{{ element.name }}</span>
                            </div>
                        </template>
                    </draggable>
                </div>
            </div>
        </div>
    </div>
</template>

<style>

</style>
