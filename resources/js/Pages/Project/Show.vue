<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { computed } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';

const props = defineProps({
    errors: Object,
    project: Object
})

const showCreatePackageModal = ref(false)
const showCreateSubPackageModal = ref(false)

const closeCreatePackageModal = () => {
    showCreatePackageModal.value = false
    formPackage.reset()
}

const closeCreateSubPackageModal = () => {
    showCreateSubPackageModal.value = false
    formPackage.reset()
}

const formPackage = useForm({
    name: ''
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

const handleSubmitSubPackage = () => {
    formSubPackage.post(route('project.package.store-subpackage', props.project.data.id), {
        onSuccess: () => {
            closeCreateSubPackageModal()
            formSubPackage.reset()
        }
    })
}

const deletePackage = (id) => {
    if (confirm('Apakah anda yakin ingin menghapus paket pekerjaan ini?')) {
        router.delete(route('project.package.destroy', [props.project.data.id, id]))
    }
}
</script>
<template>
    <AuthenticatedLayout>
        <Head :title="`Project ${project.data.name}`"/>
        <div class="flex flex-row justify-between px-4 py-3 bg-white border-b shadow-sm">
            <div class="flex flex-col">
                <div class="flex flex-row items-center gap-2">
                    <Link :href="route('project.index')" class="text-lg font-semibold capitalize">
                        Project
                    </Link>
                    <h5 class="text-lg font-medium capitalize">
                        / {{ project.data.name }}
                    </h5>
                </div>
                <div class="flex flex-row gap-2">
                    <button @click="showCreatePackageModal = true" class="px-2 py-1 text-sm font-semibold text-white bg-stone-700">+ Paket Pekerjaan</button>
                </div>
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

        <div class="flex h-screen gap-4 px-4 py-3 overflow-auto flex-nowrap">
            <div class="flex-none bg-white border w-80 h-min" v-for="taskPackage in project.data.packages" :key="taskPackage.id">
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
            </div>
        </div>

        <Modal :show="showCreatePackageModal" @close="closeCreatePackageModal" max-width="lg" :closeable="false">
            <form @submit.prevent="handleSubmitPackage">
                <div class="flex justify-between p-4 border-b">
                    <h5 class="text-base font-semibold">
                        Buat Paket Pekerjaan Baru
                    </h5>
                    <button type="button" @click="closeCreatePackageModal" class="p-[2px] rounded hover:bg-stone-100">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="px-4 py-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 after:content-['*'] after:text-red-500">
                                Nama Paket Pekerjaan
                            </label>
                            <input type="text" v-model="formPackage.name"
                                class="block w-full p-0 text-xl text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                placeholder="Nama paket pekerjaan" required @keydown.enter="handleSubmitPackage">
                            <template v-if="errors.name">
                                <span class="text-sm text-red-500">{{ errors.name }}</span>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="p-4 border-t">
                    <PrimaryButton type="submit" :disabled="formPackage.processing">Simpan</PrimaryButton>
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
    </AuthenticatedLayout>
</template>
