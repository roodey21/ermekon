<script setup>
import { Link, router, Head, useForm, usePage } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import Modal from '@/Components/Modal.vue'
import { toast } from 'vue3-toastify'

import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue'

const page = usePage()
const props = defineProps({
    errors: Object,
    project: Object,
    taskPackage: Object
})

const formTask = useForm({
    name: '',
    description: '',
    package_id: '',
})

const formSubPackage = useForm({
    name: '',
    parent_id: props.taskPackage.data.id,
})
const createTaskModal = ref(false)
const createSubPackageModal = ref(false)

const showCreateTaskModal = (package_id) => {
    createTaskModal.value = true
    formTask.package_id = package_id
}
const closeCreateTaskModal = () => {
    createTaskModal.value = false
    formTask.reset()
}

const showCreateSubPackageModal = (package_id) => {
    createSubPackageModal.value = true
    formSubPackage.parent_id = package_id
}
const closeCreateSubPackageModal = () => {
    createSubPackageModal.value = false
    formSubPackage.reset()
}

const handleSubmitTask = () => {
    const toastCreate = toast.loading('Sedang Menyimpan')
    formTask.post(route('project.package.task.store', props.project.data.id), {
        onSuccess: () => {
            if (page.props.flash.success) {
                setTimeout(() => {
                    toast.update(toastCreate,{
                        render: page.props.flash.success,
                        type: 'success',
                        autoClose: true,
                        isLoading: false,
                    })
                }, 2000)
                closeCreateTaskModal()
                formTask.reset()
            }
        }
    })
}
const handleSubmitSubPackage = () => {
    const toastCreate = toast.loading('Sedang Menyimpan')
    formSubPackage.post(route('project.package.store-subpackage', props.project.data.id), {
        onSuccess: () => {
            if (page.props.flash.success) {
                setTimeout(() => {
                    toast.update(toastCreate,{
                        render: page.props.flash.success,
                        type: 'success',
                        autoClose: true,
                        isLoading: false,
                    })
                }, 2000)
                closeCreateSubPackageModal()
                formSubPackage.reset()
            }
        }
    })
}

const deleteSubPackage = (id) => {
    if (confirm('Apakah anda yakin ingin menghapus sub paket pekerjaan ini? semua pekerjaan yang ada di dalam sub paket ini akan ikut terhapus!')) {
        router.delete(route('project.package.destroy-subpackage', [props.project.data.id, id]))
    }
}
</script>
<template>
    <AuthenticatedLayout>
        <Head title="Paket Pekerjaan" />

        <div class="sticky z-10 flex items-center gap-2 px-4 py-3 bg-white border-b top-12">
            <Link :href="route('project.index')" class="text-xl font-semibold leading-tight text-gray-800 after:content-['/'] after:ml-2">Project</Link>
            <Link :href="route('project.show', props.project.data.id)" class="text-lg font-semibold leading-tight text-gray-800 after:content-['/'] after:ml-2">
                {{ project.data.name }}
            </Link>
            <h3 class="text-lg font-semibold leading-tight text-gray-800">
                {{ taskPackage.data.name }}
            </h3>
        </div>

        <div class="flex h-screen gap-4 px-4 py-3 overflow-auto flex-nowrap">
            <div class="flex-none w-80 h-min group" v-for="subpackage in taskPackage.data.subpackages" :key="subpackage.id">
                <div class="block p-2 mb-2 bg-white border hover:cursor-pointer">
                    <div class="flex flex-row justify-between">
                        <h6 class="text-sm font-semibold">
                            {{ subpackage.name }}
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
                                    <li class="px-2 py-1 hover:bg-stone-100" @click="deleteSubPackage(subpackage.id)">
                                        Hapus
                                    </li>
                                    <li class="px-2 py-1 hover:bg-stone-100 text-stone-500">
                                        Edit
                                    </li>
                                </ul>
                            </template>
                        </Dropdown>
                    </div>
                </div>
                <div class="flex flex-col gap-1">
                    <template v-if="subpackage.tasks">
                        <div @click="router.get(route('project.package.task.show', [project.data.id, task.id]))"
                            class="p-2 relative text-sm font-medium bg-white border hover:cursor-pointer hover:bg-stone-50 group/list"
                            v-for="task in subpackage.tasks" :key="task.id">
                            {{ task.name }}
                            <span class="absolute top-1/2 right-2 -translate-y-1/2 opacity-0 group-hover/list:opacity-100">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3 text-stone-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </span>
                        </div>
                    </template>
                    <button type="button" @click="showCreateTaskModal(subpackage.id)" class="flex items-center justify-center w-full p-2 text-sm font-medium text-center text-white transition-all duration-200 border opacity-0 bg-stone-800 group-hover:opacity-100 hover:cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                        <span class="text-sm font-medium capitalize">Tambah Pekerjaan</span>
                    </button>
                </div>
            </div>
            <div class="flex-none w-80 h-min group">
                <div @click="showCreateSubPackageModal(taskPackage.data.id)" class="block p-2 mb-2 bg-white border hover:cursor-pointer hover:bg-stone-50">
                    <div class="flex flex-row items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                        <h6 class="text-sm font-semibold">
                            Tambah Sub Paket Pekerjaan
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="createTaskModal" @close="closeCreateTaskModal" max-width="2xl" :closeable="false">
            <form @submit.prevent="handleSubmitTask">
                <div class="flex justify-between p-4 border-b">
                    <h5 class="text-base font-semibold">
                        Buat Pekerjaan Baru
                    </h5>
                    <button type="button" @click="closeCreateTaskModal" class="p-[2px] rounded hover:bg-stone-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-4 py-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 after:content-['*'] after:text-red-500">
                                Nama Item Pekerjaan
                            </label>
                            <input type="text" v-model="formTask.name"
                                class="block w-full p-0 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                placeholder="Nama Item pekerjaan" required>
                            <template v-if="errors.name">
                                <span class="text-sm text-red-500">{{ errors.name }}</span>
                            </template>
                        </div>
                        <div class="col-span-1">
                            <label for="package_id" class="block mb-2 text-sm font-medium text-gray-900">
                                Untuk Paket Pekerjaan
                            </label>
                            <select v-model="formTask.package_id"
                                class="block w-full p-0 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                placeholder="Paket Pekerjaan" disabled>
                                <option :value="subpackage.id" v-for="subpackage in taskPackage.data.subpackages" :key="subpackage.id">{{ subpackage.name }}</option>
                            </select>
                            <template v-if="errors.package_id">
                                <span class="text-sm text-red-500">{{ errors.package_id }}</span>
                            </template>
                        </div>
                        <div class="col-span-2">
                            <label for="description" class="block mb-2 text-sm font-medium text-gray-900">
                                Note / Deskripsi Pekerjaan
                            </label>
                            <textarea rows="4" v-model="formTask.description"
                                class="block w-full p-0 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                placeholder="Tulis deskripsi ...">
                            </textarea>
                            <template v-if="errors.description">
                                <span class="text-sm text-red-500">{{ errors.description }}</span>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t">
                    <PrimaryButton type="submit" :disabled="formTask.processing">Simpan</PrimaryButton>
                </div>
            </form>
        </Modal>
        <Modal :show="createSubPackageModal" @close="closeCreateSubPackageModal" max-width="lg">
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
    </AuthenticatedLayout>
</template>
