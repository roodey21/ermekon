<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TableGroupList from '@/Components/Table/TableGroupList.vue';
import ListGroup from '@/Components/ListGroup/ListGroup.vue';
import TaskList from '@/Components/ListGroup/TaskList.vue';
import SubTaskList from '@/Components/ListGroup/SubTaskList.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { nextTick, ref, computed } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import axios from 'axios';
import Tiptap from '@/Components/Tiptap.vue';
import { ChevronDownIcon, ArrowUturnLeftIcon, PencilSquareIcon, TrashIcon, LinkIcon, EllipsisHorizontalIcon, TableCellsIcon, CheckCircleIcon, DocumentIcon, FolderIcon } from '@heroicons/vue/24/outline';
import UpdateProjectModal from './Partials/UpdateProjectModal.vue';
import UpdatePackageModal from './Partials/UpdatePackageModal.vue';
import CreatePackageModal from './Partials/CreatePackageModal.vue';
import CreateTaskModal from './Partials/CreateTaskModal.vue';

const props = defineProps({
    projects: Object,
    errors: Object,
    project: Object,
    products: {
        type: Object,
        default: () => ({
            data: []
        })
    }
})

const showCreateTaskModal = ref(false)
const showEditPackageModal = ref(false)

const closeEditPackageModal = () => {
    showEditPackageModal.value = false
    formPackage.reset()
}

const closeCreateTaskModal = () => {
    showCreateTaskModal.value = false
}

const formPackage = useForm({
    name: '',
    description: ''
})

const formSubPackage = useForm({
    name: '',
    parent_id: ''
})

const handleSubmitSubPackage = () => {
    formSubPackage.post(route('project.package.store-subpackage', props.project.data.id), {
        onSuccess: () => {
            closeCreateSubPackageModal()
            formSubPackage.reset()
        }
    })
}

const handleSubmitUpdatePackage = () => {
    console.log('clicked');
    editPackageForm.put(route('project.package.update', [ props.project.data.id, editPackageForm.id ]), {
        onSuccess: () => {
            closeEditPackageModal()
            editPackageForm.reset()
        }
    })
}

const isSearching = ref(false)

const searchProduct = (search) => {
    router.reload({
        only: ['products'],
        data: {
            search
        }
    })
}

const createTaskForm = useForm({
    name: '',
    package_id: '',
    description: '',
    products : []
})

const test = ref(null)

const editPackageForm = useForm({
    id: null,
    name:'',
    description:''
})

const addTaskItem = () => {
    createTaskForm.products.push({
        id: null,
        name: ''
    })
};

const editPackage = (packageId) => {
    const packageData = props.project.data.packages.find(item => item.id == packageId)
    editPackageForm.id = packageData.id
    editPackageForm.name = packageData.name
    editPackageForm.description = packageData.description
    showEditPackageModal.value = true
}

const deleteTaskItem = (task) => {
    createTaskForm.products.splice(task, 1)
}

const handleDeleteSubPackage = (task) => {
    console.log(task)
    router.delete(route('project.package.destroy-subpackage', [props.project.data.id, task]))
}

const updateNameSubPackageForm = useForm({
    name:'',
    description:''
})

defineOptions({
    layout: AuthenticatedLayout,
})

const showMenuPackage = ref(false)

const updateProjectModal = ref(null)
const updatePackageModal = ref(null)
const createPackageModal = ref(null)
const createTaskModal = ref(null)

const createTask = (args) => {
    createTaskModal.value.openModal(...args)
}

const openEditProjectModal = () => {
    updateProjectModal.value.openModal()
}

const openCreatePackageModal = () => {
    createPackageModal.value.openModal()
}

const openEditPackageModal = (id) => {
    updatePackageModal.value.openModal(id)
}
</script>
<template>
    <Head :title="`Project ${project.data.name}`"/>

    <div class="overflow-y-auto grow">
        <div class="flex flex-row justify-between p-4 bg-teal-700 shadow">
            <div class="flex items-center gap-3">
                <Dropdown align="left">
                    <template #trigger>
                        <div class="flex items-center gap-0.5 hover:cursor-pointer">
                            <h3 class="text-white">
                                {{ project.data.name }}
                            </h3>
                            <ChevronDownIcon class="w-4 h-4 text-white"/>
                        </div>
                    </template>

                    <template #content>
                        <ul class="p-1.5 text-black">
                            <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded">
                                <Link :href="route('project.index')" class="flex items-center gap-2 text-xs">
                                    <ArrowUturnLeftIcon class="w-3 h-3"/> <span>Kembali ke List Proyek</span>
                                </Link>
                            </li>
                            <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded" @click="openEditProjectModal">
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
                <div class="w-[1px] bg-white/50 h-6"></div>
                <button type="button" @click="openCreatePackageModal" class="flex items-center text-white py-0.5 px-1 gap-1 text-xs font-medium rounded bg-teal-800">
                    <svg class="w-2.5 h-2.5" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.99984 8.33341V5.00008M4.99984 5.00008V1.66675M4.99984 5.00008H8.33317M4.99984 5.00008H1.6665" stroke="white" stroke-width="1.16667" stroke-linecap="round"/>
                    </svg>
                    Paket Pekerjaan
                </button>
            </div>
            <div class="flex items-center w-full max-w-xs border rounded h-min border-stone-400">
                <span class="px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </span>
                <input type="text" class="w-full px-2 py-1 text-sm font-semibold border-0 placeholder:text-sm" placeholder="Cari disini ...">
            </div>
        </div>
        <div class="px-4 mt-5">
            <div class="flex w-full gap-2 p-4 overflow-x-auto bg-white border rounded-lg shadow">
                <div class="flex items-center gap-1.5 px-2 py-1 text-sm font-medium text-gray-600 transition-all border-b-2 border-teal-700 border-opacity-0 hover:border-opacity-100 hover:cursor-pointer">
                    <TableCellsIcon class="w-4 h-4"/> Overview
                </div>
                <div class="flex items-center gap-1.5 px-2 py-1 text-sm font-medium text-gray-600 transition-all border-b-2 border-teal-700 border-opacity-0 hover:border-opacity-100 hover:cursor-pointer">
                    <FolderIcon class="w-4 h-4" /> BoQ
                </div>
                <div class="flex items-center gap-1.5 px-2 py-1 text-sm font-medium text-gray-600 transition-all border-b-2 border-teal-700 border-opacity-0 hover:border-opacity-100 hover:cursor-pointer">
                    <CheckCircleIcon class="w-4 h-4" /> Tasks
                </div>
                <div class="flex items-center gap-1.5 px-2 py-1 text-sm font-medium text-gray-600 transition-all border-b-2 border-teal-700 border-opacity-0 hover:border-opacity-100 hover:cursor-pointer">
                    <DocumentIcon class="w-4 h-4" /> Files
                </div>
            </div>
        </div>

        <div class="flex flex-col px-4 mt-5 space-y-5">
            <ListGroup
                :projectPackage="projectPackage"
                v-for="projectPackage in project.data.packages" :key="projectPackage.id"
                @update-package="openEditPackageModal(projectPackage.id)">
                <TaskList
                    :subpackage="subpackage"
                    :projectId="project.data.id" :package-id="projectPackage.id"
                    v-for="subpackage in projectPackage.subpackages" :key="subpackage.id"
                    @show-add-item="createTask"
                    @show-delete-sub-package="handleDeleteSubPackage">
                    <SubTaskList :task="task" v-for="task in subpackage.tasks" :key="task.id" />
                </TaskList>
            </ListGroup>
        </div>
    </div>

    <UpdateProjectModal :project="project" ref="updateProjectModal"/>

    <CreatePackageModal :project="project" ref="createPackageModal"/>

    <UpdatePackageModal :project="project" ref="updatePackageModal"/>

    <CreateTaskModal :project="project" :products="products" ref="createTaskModal"/>
</template>

<style>
table tr th {
    padding: 4px 4px;
}
table tr td {
    padding: 8px 4px;
}
.vs__dropdown-menu {
    max-height: 150px;
    z-index: 60;
    -ms-overflow-style: none;
    /* scrollbar-width: none; */
}
.vs__dropdown-menu::-webkit-scrollbar {
    display: none;
}
</style>
