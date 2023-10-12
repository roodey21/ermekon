<script>

</script>

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
import { ChevronDownIcon, ArrowUturnLeftIcon, PencilSquareIcon, TrashIcon, LinkIcon, EllipsisHorizontalIcon } from '@heroicons/vue/24/outline';

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

const showCreatePackageModal = ref(false)
const showCreateSubPackageModal = ref(false)
const showCreateTaskModal = ref(false)
const showEditPackageModal = ref(false)
const showEditProjectModal = ref(false)

const closeEditProjectModal = () => {
    showEditProjectModal.value = false
    editProjectForm.reset()
}

const editProjectForm = useForm({
    name: props.project.data.name,
    client_name: props.project.data.client_name,
    client_telephone: props.project.data.client_telephone,
    description: props.project.data.description
})

const handleSubmitUpdateProject = () => {
    // editProjectForm.put(route('project.update', props.project.data.id), {
    //     onSuccess: () => {
    //         closeEditProjectModal()
    //         editProjectForm.reset()
    //     }
    // })
    console.log('submitted')
}

const closeEditPackageModal = () => {
    showEditPackageModal.value = false
    formPackage.reset()
}

const closeCreatePackageModal = () => {
    showCreatePackageModal.value = false
    formPackage.reset()
}

const closeCreateSubPackageModal = () => {
    showCreateSubPackageModal.value = false
    formPackage.reset()
}

const closeCreateTaskModal = () => {
    showCreateTaskModal.value = false
    // formPackage.reset()
}

const formPackage = useForm({
    name: '',
    description: ''
})

const formSubPackage = useForm({
    name: '',
    parent_id: ''
})

const addSubPackage = (id) => {
    const parentPackage = props.project.data.packages.find(item => item.id == id)
    formSubPackage.parent_id = parentPackage.id
    showCreateSubPackageModal.value = true
}

const handleSubmitPackage = () => {
    formPackage.post(route('project.package.store', props.project.data.id), {
        onSuccess: () => {
            closeCreatePackageModal()
            formPackage.reset()
        }
    })
}

const namePackage = ref(null)

const handleShowCreatePackageModal = async () => {
    showCreatePackageModal.value = true
    await nextTick()
    namePackage.value.focus()
}

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

const createTask = (packageId) => {
    createTaskForm.package_id = packageId
    showCreateTaskModal.value = true
}

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
</script>
<template>
    <!-- <AuthenticatedLayout> -->
        <Head :title="`Project ${project.data.name}`"/>

        <!-- <nav class="flex h-full px-5 py-6 bg-white shadow w-72">
            <div class="flex flex-col w-full">
                <div
                    class="flex flex-col link-group">
                    <h5 class="mb-4 text-lg text-gray-800">List Proyek</h5>
                    <template v-if="projects.data">
                        <Link
                            v-for="project in projects.data"
                            :key="project.id"
                            :href="route('project.show', project.id)"
                            :class="$page.url && route().current('project.show', { project : project.id}) ? 'bg-gray-300/50' : ''"
                            class="flex gap-3 px-3 py-2 text-sm font-medium text-gray-800 hover:bg-gray-200">
                            <span class="line-clamp-1">
                                {{ project.name }}
                            </span>
                        </Link>
                    </template>
                </div>
            </div>
        </nav> -->
        <div class="overflow-y-auto grow">
            <div class="flex flex-row justify-between p-4 bg-teal-700 shadow">
                <div class="flex items-center gap-3">
                    <Dropdown align="left">
                        <template #trigger>
                            <div class="flex items-center gap-2 hover:cursor-pointer">
                                <h3 class="text-white">
                                    {{ project.data.name }}
                                </h3>
                                <ChevronDownIcon class="w-5 h-5 text-white"/>
                            </div>
                        </template>

                        <template #content>
                            <ul class="p-1.5 text-black">
                                <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded">
                                    <Link :href="route('project.index')" class="flex items-center gap-2 text-xs">
                                        <ArrowUturnLeftIcon class="w-3 h-3"/> <span>Kembali ke List Proyek</span>
                                    </Link>
                                </li>
                                <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded" @click="showEditProjectModal=true">
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
                    <!-- <div class="relative rounded" >
                        <div class="flex items-center gap-2 hover:cursor-pointer">
                            <h3 class="text-white">
                                {{ project.data.name }}
                            </h3>
                            <ChevronDownIcon class="w-5 h-5 text-white"/>
                        </div>
                        <div v-show="showMenu" class="fixed inset-0 z-40" @click="showMenu=false"></div>
                        <div v-show="showMenu" class="absolute z-50 translate-y-full bg-white border rounded shadow w-52 left-2 -bottom-1">
                            <ul class="p-1.5 text-black">
                                <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded">
                                    <Link :href="route('project.index')" class="flex items-center gap-2 text-xs">
                                        <ArrowUturnLeftIcon class="w-3 h-3"/> <span>Kembali ke List Proyek</span>
                                    </Link>
                                </li>
                                <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded" @click="showEditProjectModal=true">
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
                        </div>
                    </div> -->
                    <div class="w-[1px] bg-white/50 h-6"></div>
                    <button type="button" @click="handleShowCreatePackageModal" class="flex items-center text-white py-0.5 px-1 gap-1 text-xs font-medium rounded bg-teal-800">
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

            <div class="flex flex-col px-4 mt-5 space-y-5">
                <!-- <TableGroupList v-for="projectPackage in project.data.packages" :key="projectPackage.id" :projectPackage="projectPackage"/> -->
                <ListGroup
                    :projectPackage="projectPackage"
                    v-for="projectPackage in project.data.packages" :key="projectPackage.id"
                    @update-package="editPackage">
                    <TaskList
                        :subpackage="subpackage"
                        :projectId="project.data.id"
                        v-for="subpackage in projectPackage.subpackages" :key="subpackage.id"
                        @show-add-item="createTask(subpackage.id)"
                        @show-delete-sub-package="handleDeleteSubPackage">
                        <SubTaskList :task="task" v-for="task in subpackage.tasks" :key="task.id" />
                    </TaskList>
                </ListGroup>
                <!-- <div class="flex-none bg-white border w-80 h-min" v-for="taskPackage in project.data.packages" :key="taskPackage.id">
                    <div class="block p-2 border-b">
                        <div class="flex flex-row justify-between">
                            <h6 @click="router.get(route('project.package.show', [ project.data.id, taskPackage.id ]))" class="text-sm font-semibold hover:underline hover:cursor-pointer">
                                {{ taskPackage.name }}
                            </h6>
                            <Dropdown align="center" width="48">
                                <template #trigger>
                                    <button class="hover:bg-stone-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 12.75a.75.75 0 110-1.5.75.75 0 010 1.5zM12 18.75a.75.75 0 110-1.5.75.75 0 010 1.5z" />
                                        </svg>
                                    </button>
                                </template>

                                <template #content>
                                    <ul class="space-y-1 text-sm">
                                        <li class="px-2 py-1 hover:bg-stone-100 hover:cursor-pointer" @click="deletePackage(taskPackage.id)">
                                            Hapus
                                        </li>
                                        <li class="px-2 py-1 bg-stone-100 text-stone-500">
                                            Edit
                                        </li>
                                    </ul>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1 p-2">
                        <template v-if="taskPackage.subpackages">
                            <Link :href="route('project.package.show', [ project.data.id, taskPackage.id ])" class="p-2 text-sm font-medium hover:cursor-pointer bg-stone-100 hover:bg-stone-200"
                                v-for="subpackage in taskPackage.subpackages" :key="subpackage.id">
                                {{ subpackage.name }}
                            </Link>
                        </template>

                        <button type="button" @click="addSubPackage(taskPackage.id)" class="flex items-center justify-center w-full p-2 text-center rounded bg-stone-700 hover:cursor-pointer hover:bg-stone-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-white">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                            </svg>
                            <span class="text-xs font-medium capitalize text-stone-50">sub paket pekerjaan {{ taskPackage.id }}</span>
                        </button>
                    </div>
                    <div class="flex flex-row justify-between p-2 border-t">
                        <div></div>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M12 17.25h8.25" />
                            </svg>
                        </button>
                    </div>
                </div> -->
            </div>
        </div>

        <EditProjectModal :project="project"/>
        <Modal :show="showCreatePackageModal" @close="closeCreatePackageModal" max-width="2xl" :closeable="true">
            <form @submit.prevent="handleSubmitPackage">
                <div class="flex items-center justify-between px-4 py-3 bg-gray-100 border-b">
                    <h5 class="text-sm font-medium">
                        Buat Paket Pekerjaan Baru
                    </h5>
                    <button type="button" @click="closeCreatePackageModal" class="p-[2px] rounded bg-white border">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-4 py-6">
                    <div class="mb-2">
                        <input type="text"
                            ref="namePackage"
                            class="w-full p-2 -ml-2 text-2xl font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                            v-model="formPackage.name"
                            placeholder="Nama Paket Pekerjaan">
                    </div>
                    <div class="mb-2">
                        <textarea
                            rows="8"
                            class="w-full p-2 -ml-2 text-sm font-light text-gray-900 border border-gray-200 border-opacity-0 rounded placeholder:text-gray-600 focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                            placeholder="deskripsi atau catatan lainnya ditulis disini"
                            v-model="formPackage.description"></textarea>
                    </div>
                </div>
                <div class="p-4 border-t">
                    <PrimaryButton type="submit" :disabled="formPackage.processing">Simpan</PrimaryButton>
                </div>
            </form>
        </Modal>
        <Modal :show="showEditPackageModal" @close="closeEditPackageModal" max-width="6xl" :closeable="false">
            <form @submit.prevent="handleSubmitUpdatePackage">
                <div class="flex items-center justify-between px-4 py-3 bg-gray-100 border-b">
                    <h5 class="text-sm font-medium">
                        Edit Paket Pekerjaan
                    </h5>
                    <button type="button" @click="closeEditPackageModal" class="p-[2px] rounded bg-white border">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-row divide-x">
                    <div class="basis-3/5">
                        <div class="flex flex-row justify-between px-4 py-6 border-b">
                            <div></div>
                            <div class="relative rounded" >
                                <div class="flex items-center gap-2 hover:cursor-pointer group" @click="showMenuPackage=true">
                                    <EllipsisHorizontalIcon class="w-6 h-6 transition-all group-hover:text-teal-700 group-hover:scale-125" :class="{'text-teal-700 scale-110': showMenuPackage}"/>
                                </div>
                                <div v-show="showMenuPackage" class="fixed inset-0 z-40" @click="showMenuPackage=false"></div>
                                <div v-show="showMenuPackage" class="absolute right-0 z-50 translate-y-full bg-white border rounded shadow w-52 -bottom-1">
                                    <ul class="p-1.5 text-black">
                                        <!-- <hr class="my-1.5"> -->
                                        <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded">
                                            <div class="flex items-center gap-2 text-xs text-red-700">
                                                <TrashIcon class="w-3 h-3" />
                                                <span>Hapus Paket Pekerjaan</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-6 overflow-y-scroll">
                            <div class="mb-2">
                                <input type="text"
                                    class="w-full p-2 -ml-2 text-2xl font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                                    v-model="editPackageForm.name"
                                    placeholder="Nama Paket Pekerjaan">
                            </div>
                            <div class="mb-2">
                                <Tiptap
                                    v-model="editPackageForm.description"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-6 w-72 basis-2/5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-light">you membuat item pekerjaan ini.</span>
                            <span class="text-[11px] font-light">Yesterday at 08.00 am</span>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t">
                    <PrimaryButton type="submit" :disabled="editPackageForm.processing">Simpan</PrimaryButton>
                </div>
            </form>
        </Modal>
        <Modal :show="showCreateSubPackageModal" @close="closeCreateSubPackageModal" max-width="lg" :closeable="false">
            <form @submit.prevent="handleSubmitSubPackage">
                <div class="flex justify-between p-4 border-b">
                    <h5 class="text-base font-semibold">
                        Buat Sub Paket Pekerjaan Baru
                    </h5>
                    <button type="button" @click="closeCreateSubPackageModal" class="p-[2px] rounded hover:bg-stone-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-4 py-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 after:content-['*'] after:text-red-500">
                                Paket Pekerjaan
                            </label>
                            <select v-model="formSubPackage.parent_id"
                                class="block w-full p-0 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                placeholder="Pilih Paket Pekerjaan" required disabled>
                                <option :value="taskPackage.id" v-for="taskPackage in project.data.packages" :key="taskPackage">{{ taskPackage.name }}</option>
                            </select>
                            <template v-if="errors.parent_id">
                                <span class="text-sm text-red-500">{{ errors.parent_id }}</span>
                            </template>
                        </div>
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 after:content-['*'] after:text-red-500">
                                Nama Sub Paket Pekerjaan
                            </label>
                            <input type="text" v-model="formSubPackage.name"
                                class="block w-full p-0 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                placeholder="Nama sub paket pekerjaan" required>
                            <template v-if="errors.name">
                                <span class="text-sm text-red-500">{{ errors.name }}</span>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t">
                    <PrimaryButton type="submit" :disabled="formSubPackage.processing">Simpan</PrimaryButton>
                </div>
            </form>
        </Modal>
        <Modal :show="showCreateTaskModal" @close="closeCreateTaskModal" max-width="6xl" :closeable="false">
            <form @submit.prevent="handleSubmitSubPackage">
                <div class="flex items-center justify-between px-4 py-3 bg-gray-100 border-b">
                    <h5 class="text-sm font-medium">
                        Buat Item Pekerjaan Baru
                    </h5>
                    <button type="button" @click="closeCreateTaskModal" class="p-[2px] rounded bg-white border">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="flex flex-row divide-x">
                    <div class="px-4 py-6 basis-3/5 h-[70vh] overflow-y-scroll scroll-smooth">
                        <div class="mb-2">
                            <input type="text"
                                class="w-full p-2 -ml-2 text-2xl font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                                v-model="createTaskForm.name"
                                placeholder="Nama Item Pekerjaan">
                        </div>
                        <div class="mb-2">
                            <textarea
                                rows="8"
                                class="w-full p-2 -ml-2 text-sm font-light text-gray-900 border border-gray-200 border-opacity-0 rounded placeholder:text-gray-600 focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                                placeholder="deskripsi atau catatan lainnya ditulis disini"
                                v-model="createTaskForm.description"></textarea>
                        </div>
                        <div class="items-form">
                            <div class="flex items-center gap-3 py-2 mb-2">
                                <h6 class="text-base font-medium text-gray-600">Barang & Jasa</h6>
                                <button @click="addTaskItem" class="py-0.5 px-2 rounded border border-teal-700 text-teal-700 bg-white text-xs">
                                    Add
                                </button>
                            </div>
                            <table class="w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th></th>
                                        <th class="text-sm font-medium text-center">Nama</th>
                                        <th class="text-sm font-medium text-center">Volume</th>
                                        <th class="text-sm font-medium text-center">Jenis Transaksi</th>
                                        <th class="text-sm font-medium text-center">Harga Satuan</th>
                                    </tr>
                                </thead>
                                <tbody class="space-y-2">
                                    <tr v-for="(item, index) in createTaskForm.products" :key="item.id">
                                        <td>
                                            <span @click="deleteTaskItem(index)">
                                                x
                                            </span>
                                        </td>
                                        <td class="text-sm font-light">
                                            <span class="line-clamp-1">
                                                Pipa PVC AW dia. 4" (Pipa Tegak)
                                            </span>
                                        </td>
                                        <td class="text-sm font-light text-center" width="150px">100 m</td>
                                        <td class="text-sm font-light text-center" width="150px">Pembelian</td>
                                        <td class="text-sm font-light text-center" width="150px">50,000</td>
                                    </tr>
                                    <tr>
                                        <td class="text-sm font-light">
                                            <v-select
                                                v-model="test"
                                                :options="products.data"
                                                :reduce="product => product.id"
                                                :clearable="false"
                                                label="name"
                                                @search="searchProduct"
                                                class="searchProduct"
                                                >
                                            </v-select>
                                            <!-- <div class="relative">
                                                <input class="w-full p-0 text-sm border-0 rounded focus:border-0 focus:ring-0 placeholder:text-gray-400" placeholder="Cari barang" @input="handleSearchProduct">
                                                <template v-if="isSearching">
                                                    <div class="absolute bottom-0 z-50 w-full translate-y-full bg-white border search-wrapper">
                                                        <ul class="py-2">
                                                           <li class="p-2" v-for="product in products.data" :key="product.id">{{ product.name }}</li>
                                                        </ul>
                                                    </div>
                                                </template>
                                            </div> -->
                                        </td>
                                        <td class="text-sm font-light text-center">100 m</td>
                                        <td class="text-sm font-light text-center">Pembelian</td>
                                        <td class="text-sm font-light text-center">50,000</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">&nbsp;</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="px-4 py-6 w-72 basis-2/5">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-light">you membuat item pekerjaan ini.</span>
                            <span class="text-[11px] font-light">Yesterday at 08.00 am</span>
                        </div>
                    </div>
                    <!-- <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 after:content-['*'] after:text-red-500">
                                Paket Pekerjaan
                            </label>
                            <select v-model="formSubPackage.parent_id"
                                class="block w-full p-0 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                placeholder="Pilih Paket Pekerjaan" required disabled>
                                <option :value="taskPackage.id" v-for="taskPackage in project.data.packages" :key="taskPackage">{{ taskPackage.name }}</option>
                            </select>
                            <template v-if="errors.parent_id">
                                <span class="text-sm text-red-500">{{ errors.parent_id }}</span>
                            </template>
                        </div>
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 after:content-['*'] after:text-red-500">
                                Nama Sub Paket Pekerjaan
                            </label>
                            <input type="text" v-model="formSubPackage.name"
                                class="block w-full p-0 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                placeholder="Nama sub paket pekerjaan" required>
                            <template v-if="errors.name">
                                <span class="text-sm text-red-500">{{ errors.name }}</span>
                            </template>
                        </div>
                    </div> -->
                </div>
                <div class="p-4 text-right border-t">
                    <PrimaryButton type="submit" :disabled="formSubPackage.processing">Simpan</PrimaryButton>
                </div>
            </form>
        </Modal>
    <!-- </AuthenticatedLayout> -->
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
