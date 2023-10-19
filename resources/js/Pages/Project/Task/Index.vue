<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ArrowUturnLeftIcon, ChevronDownIcon, LinkIcon, PencilSquareIcon, PlusIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { computed, ref } from 'vue';
import draggable from 'vuedraggable';
import SubMenu from '../Partials/SubMenu.vue';
import CreateTaskModal from './Partials/CreateTaskModal.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    project: {
        type: Object,
        required: true,
    },
    tasks: {
        type: Object,
    }
})

const data = [{
    data : [
        { id: 1, name: 'task 1', status: 1},
        { id: 2, name: 'task 2', status: 2},
        { id: 3, name: 'task 3', status: 2},
        { id: 4, name: 'task 4', status: 1},
        { id: 5, name: 'task 5', status: 2},
        { id: 6, name: 'task 6', status: 1},
]
}]

const list1 = ref([
    { id: 1, name: 'Task 1' },
    { id: 2, name: 'Task 2' },
    { id: 3, name: 'Task 3' },
    { id: 4, name: 'Task 4' },
    { id: 5, name: 'Task 5' },
])

const list2 = ref([
    { id: 1, name: 'Task 1' },
    { id: 2, name: 'Task 2' },
    { id: 3, name: 'Task 3' },
    { id: 4, name: 'Task 4' },
    { id: 5, name: 'Task 5' },
])

const dropOptions = computed(() => ({
    animation: 200,
    group: 'task',
}))

defineOptions({
    layout: AuthenticatedLayout
})

const createTaskModal = ref(null)

const openCreateTask = () => {
    createTaskModal.value.openModal()
}
</script>

<template>
    <div class="flex flex-row justify-between p-4 bg-teal-700 shadow">
        <div class="flex items-center gap-3">
            <Dropdown align="left">
                <template #trigger>
                    <div class="flex items-center gap-0.5 hover:cursor-pointer">
                        <h3 class="text-white">
                            {{ project.data.name }}
                        </h3>
                        <ChevronDownIcon class="w-4 h-4 text-white" />
                    </div>
                </template>

                <template #content>
                    <ul class="p-1.5 text-black">
                        <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded">
                            <Link :href="route('project.index')" class="flex items-center gap-2 text-xs">
                            <ArrowUturnLeftIcon class="w-3 h-3" /> <span>Kembali ke List Proyek</span>
                            </Link>
                        </li>
                        <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded"

                            >
                            <div class="flex items-center gap-2 text-xs">
                                <PencilSquareIcon class="w-3 h-3" />
                                <span>Edit proyek</span>
                            </div>
                        </li>
                        <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded">
                            <div class="flex items-center gap-2 text-xs">
                                <LinkIcon class="w-3 h-3" />
                                <span>Copy link</span>
                            </div>
                        </li>
                        <hr class="my-1.5">
                        <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded">
                            <div class="flex items-center gap-2 text-xs text-red-700">
                                <TrashIcon class="w-3 h-3" />
                                <span>Hapus proyek </span>
                            </div>
                        </li>
                    </ul>
                </template>
            </Dropdown>
            <!-- <div class="w-[1px] bg-white/50 h-6"></div>
            <button type="button"
                class="flex items-center text-white py-0.5 px-1 gap-1 text-xs font-medium rounded bg-teal-800">
                <svg class="w-2.5 h-2.5" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4.99984 8.33341V5.00008M4.99984 5.00008V1.66675M4.99984 5.00008H8.33317M4.99984 5.00008H1.6665"
                        stroke="white" stroke-width="1.16667" stroke-linecap="round" />
                </svg>
                Paket Pekerjaan
            </button> -->
        </div>
        <div class="flex items-center w-full max-w-xs border rounded h-min border-stone-400">
            <span class="px-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
            </span>
            <input type="text" class="w-full px-2 py-1 text-sm font-semibold border-0 placeholder:text-sm"
                placeholder="Cari disini ...">
        </div>
    </div>
    <SubMenu :project="project" />
    <div class="w-[calc(100vw-4rem)]">
        <div class="p-4 overflow-x-auto">
            <div class="flex flex-row gap-6 flex-nowrap ">
                <div class="flex-none bg-white border rounded-lg shadow w-80 h-min">
                    <div class="flex items-center justify-between p-4 border-b">
                        <h6 class="text-base font-medium text-gray-800">
                            To Do
                        </h6>
                        <div>
                            <button type="button" @click="openCreateTask" class="p-1 bg-teal-700 border rounded">
                                <PlusIcon class="w-4 h-4 text-white" />
                            </button>
                        </div>
                    </div>
                    <draggable class="p-4 space-y-2" :list="list1" itemKey="name" group="task" v-bind="dropOptions">
                        <template #item="{ element }">
                            <div class="border-l-2 border-teal-800 rounded-lg shadow">
                                <div class="p-2 bg-white border rounded-lg">
                                    <div class="text-[10px] font-light text-gray-600 capitalize">Kategori</div>
                                    <span class="text-xs select-none">{{ element.name }}</span>
                                </div>
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
                            <button type="button" @click="openCreateTask" class="p-1 bg-teal-700 border rounded">
                                <PlusIcon class="w-4 h-4 text-white" />
                            </button>
                        </div>
                    </div>
                    <draggable class="p-4 space-y-2" :list="list2" itemKey="name" group="task" v-bind="dropOptions">
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
    <CreateTaskModal :project="project" ref="createTaskModal"/>
</template>

<style></style>
