<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ArrowUturnLeftIcon, Bars3BottomLeftIcon, ChevronDownIcon, DocumentTextIcon, LinkIcon, ListBulletIcon, PencilSquareIcon, PlusIcon, TrashIcon, UserPlusIcon } from '@heroicons/vue/24/outline';
import { computed, ref } from 'vue';
import draggable from 'vuedraggable';
import SubMenu from '../Partials/SubMenu.vue';
import CreateTaskModal from './Partials/CreateTaskModal.vue';
import UpdateTaskModal from './Partials/UpdateTaskModal.vue';
import { Link, router } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { getInitial } from '@/Helpers/getInitial';
import Tooltip from '@/Components/Tooltip.vue';

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
    columns: {
        type: Object,
    },
    taskStatuses: {
        type: Object,
    },
})

const dropOptions = computed(() => ({
    animation: 200,
    group: 'task',
}))

defineOptions({
    layout: AuthenticatedLayout
})

const createTaskModal = ref(null)

const updateTaskModal = ref(null)

const openCreateTask = (statusId) => {
    createTaskModal.value.openModal(statusId)
}

const openUpdateTask = (task) => {
    updateTaskModal.value.openModal(task)
}

const handleChange = (event) => {
    console.log(event)
    // router.patch(route('project.task.update-status', [props.project.data.id, event.moved.element.id]), {
    //     data: {
    //         status_id: event.to.id
    //     }
    // })
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
                        <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded">
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
            <template v-if="columns.length">
                <draggable class="flex flex-row gap-6 flex-nowrap " :list="columns" item-key="id" group="status" v-bind="dropOptions">
                    <template #item="{ element }">
                        <div class="flex-none bg-white border rounded-lg shadow w-80 h-min">
                            <div class="flex items-center justify-between p-4 border-b">
                                <h6 class="text-base font-medium text-gray-800 capitalize">
                                    {{ element.name }}
                                </h6>
                                <div>
                                    <button type="button" @click="openCreateTask(element.id)" class="p-1 bg-teal-700 border rounded">
                                        <PlusIcon class="w-4 h-4 text-white" />
                                    </button>
                                </div>
                            </div>
                            <draggable class="p-4 space-y-2" :list="element.tasks.data" item-key="id" group="task" v-bind="dropOptions" @drop="handleChange">
                                <template #item="{ element }">
                                    <div class="border-l-2 border-teal-800 rounded-lg shadow" @click="openUpdateTask(element)">
                                        <div class="border rounded-lg">
                                            <div class="p-2 bg-white">
                                                <div class="mb-2 text-sm select-none">{{ element.name }}</div>
                                                <div class="flex gap-2">
                                                    <template v-if="element.description">
                                                        <Tooltip text="Catatan">
                                                            <div class="p-[2px] flex border rounded-sm hover:bg-gray-100 cursor-pointer items-center">
                                                                <Bars3BottomLeftIcon class="w-4 h-4" />
                                                            </div>
                                                        </Tooltip>
                                                    </template>
                                                    <template v-if="element.files.length">
                                                        <Tooltip :text="element.files.length+' Attachment'">
                                                            <div class="flex items-center border p-[2px] rounded-sm hover:bg-gray-100 cursor-pointer">
                                                                <DocumentTextIcon class="w-4 h-4" />
                                                                <span class="text-xs font-medium ml-[2px]">{{ element.files.length }}</span>
                                                            </div>
                                                        </Tooltip>
                                                    </template>
                                                    <!-- <ListBulletIcon class="w-4 h-4" /> -->
                                                </div>
                                            </div>
                                            <div class="p-2 mt-2 border-t">
                                                <div class="flex flex-row-reverse justify-end mx-2">
                                                    <template v-if="element.assignees">
                                                        <Tooltip :text="assignee.name"  v-for="assignee in element.assignees" :key="assignee.id">
                                                            <div class="w-6 h-6 bg-teal-600 -ml-2 cursor-pointer border flex justify-center items-center border-white rounded-full text-[10px] text-white">{{ getInitial(assignee.name) }}</div>
                                                        </Tooltip>
                                                    </template>
                                                    <template v-if="element.assignees == null || !element.assignees.length">
                                                        <div class="w-6 h-6 bg-white -ml-2 border flex justify-center items-center border-teal-600 border-dashed rounded-full text-[10px] text-teal-600 hover:cursor-pointer">
                                                            <UserPlusIcon class="w-4 h-4" />
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </template>
                            </draggable>
                        </div>
                    </template>
                </draggable>
            </template>
            <template v-else>
                Buat baru
            </template>
        </div>
    </div>
    <CreateTaskModal :project="project" ref="createTaskModal" :task-statuses="taskStatuses"/>

    <UpdateTaskModal :project="project" ref="updateTaskModal" :task-statuses="taskStatuses"/>
</template>

<style></style>
