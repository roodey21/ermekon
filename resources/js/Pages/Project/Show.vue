<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { computed } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';

const props = defineProps({
    projects: Object,
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
        <template #sidebar>
            <nav class="flex px-5 py-6 border-r w-72 bg-emerald-700 border-emerald-600">
                <div class="flex flex-col w-full">
                    <h2 class="mb-3 text-2xl font-medium text-white">
                        Proyek
                    </h2>
                    <div class="flex flex-col mb-6 space-y-2 link-group">
                        <Link :href="route('project.index')"
                            class="flex gap-3 px-3 py-2 text-lg font-medium text-white rounded-lg fill-white"
                            :class="route().current('project.index') ? 'bg-amber-500' : 'bg-emerald-600 hover:bg-opacity-80'">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.675 20.375L20.375 19.675L18.5 17.8V15H17.5V18.2L19.675 20.375ZM5 21C4.45 21 3.979 20.804 3.587 20.412C3.195 20.02 2.99934 19.5493 3 19V5C3 4.45 3.196 3.979 3.588 3.587C3.98 3.195 4.45067 2.99934 5 3H19C19.55 3 20.021 3.196 20.413 3.588C20.805 3.98 21.0007 4.45067 21 5V11.7C20.6833 11.55 20.3583 11.4207 20.025 11.312C19.6917 11.2033 19.35 11.1243 19 11.075V5H5V19H11.05C11.1 19.3667 11.1793 19.7167 11.288 20.05C11.3967 20.3833 11.5257 20.7 11.675 21H5ZM5 18V19V5V11.075V11V18ZM7 17H11.075C11.125 16.65 11.2043 16.3083 11.313 15.975C11.4217 15.6417 11.5423 15.3167 11.675 15H7V17ZM7 13H13.1C13.6333 12.5 14.2293 12.0833 14.888 11.75C15.5467 11.4167 16.2507 11.1917 17 11.075V11H7V13ZM7 9H17V7H7V9ZM18 23C16.6167 23 15.4373 22.5123 14.462 21.537C13.4867 20.5617 12.9993 19.3827 13 18C13 16.6167 13.4877 15.4373 14.463 14.462C15.4383 13.4867 16.6173 12.9993 18 13C19.3833 13 20.5627 13.4877 21.538 14.463C22.5133 15.4383 23.0007 16.6173 23 18C23 19.3833 22.5123 20.5627 21.537 21.538C20.5617 22.5133 19.3827 23.0007 18 23Z" />
                        </svg>
                        Overview
                        </Link>
                        <Link
                            :href="route('project.show', project.data.id)"
                            class="flex gap-3 px-3 py-2 text-lg font-medium text-white rounded-lg fill-white"
                            :class="route().current('project.show') ? 'bg-amber-500' : 'bg-emerald-600 hover:bg-opacity-80'">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="auto" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4 10.5C3.17 10.5 2.5 11.17 2.5 12C2.5 12.83 3.17 13.5 4 13.5C4.83 13.5 5.5 12.83 5.5 12C5.5 11.17 4.83 10.5 4 10.5ZM4 4.5C3.17 4.5 2.5 5.17 2.5 6C2.5 6.83 3.17 7.5 4 7.5C4.83 7.5 5.5 6.83 5.5 6C5.5 5.17 4.83 4.5 4 4.5ZM4 16.5C3.17 16.5 2.5 17.18 2.5 18C2.5 18.82 3.18 19.5 4 19.5C4.82 19.5 5.5 18.82 5.5 18C5.5 17.18 4.83 16.5 4 16.5ZM8 19H20C20.55 19 21 18.55 21 18C21 17.45 20.55 17 20 17H8C7.45 17 7 17.45 7 18C7 18.55 7.45 19 8 19ZM8 13H20C20.55 13 21 12.55 21 12C21 11.45 20.55 11 20 11H8C7.45 11 7 11.45 7 12C7 12.55 7.45 13 8 13ZM7 6C7 6.55 7.45 7 8 7H20C20.55 7 21 6.55 21 6C21 5.45 20.55 5 20 5H8C7.45 5 7 5.45 7 6Z" />
                            </svg>
                            List Proyek
                        </Link>
                    </div>
                    <div
                        class="flex flex-col pt-6 space-y-2 border-t link-group border-emerald-600">
                        <h5 class="text-lg text-white">List Proyek</h5>
                        <template v-if="projects.data">
                            <Link
                                v-for="project in projects.data"
                                :key="project.id"
                                :href="route('project.show', project.id)"
                                :class="route().current('project.show') ? 'bg-amber-500' : 'bg-emerald-600 hover:bg-opacity-80'"
                                class="flex gap-3 px-3 py-2 text-sm font-medium text-white rounded-lg fill-white">
                                <span class="line-clamp-1">
                                    {{ project.name }}
                                </span>
                            </Link>
                        </template>
                    </div>
                </div>
            </nav>
        </template>
        <div class="flex flex-row justify-between p-4 rounded-lg shadow bg-emerald-700">
            <div class="flex items-center gap-3">
                <h3 class="text-white">
                    {{ project.data.name }}
                </h3>
                <div class="w-[1px] bg-white/50 h-6">

                </div>
                <button type="button" @click="showCreatePackageModal = true" class="flex items-center text-white py-0.5 px-1 gap-1 text-xs font-medium rounded bg-emerald-800">
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

        <div class="flex mt-5 space-y-5">
            <div class="w-full bg-white border rounded-lg shadow">
                <div class="flex flex-col p-3 header">
                    <div class="flex gap-2 mb-3">
                        <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 7.5L9 14.1667L15 7.5" stroke="black" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div class="flex items-center gap-3">
                            <h5 class="text-base font-normal text-black">
                                Plumbing
                            </h5>
                            <span class="bg-amber-500 text-white px-2 py-0.5 text-[10px] uppercase rounded-full">
                                3 Sub Pekerjaan
                            </span>
                        </div>
                    </div>
                    <p class="text-sm pl-7 font-extralight">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta expedita, autem vitae eum, dolorum pariatur iste perferendis ullam tempore vero exercitationem, labore rerum est neque porro. Dicta optio numquam ex!
                    </p>
                </div>
                <div class="body">
                    <div class="flex px-8 border-b border-gray-300 table-header">
                        <div class="py-2 grow">
                            <div class="text-sm font-medium">
                                Sub Paket Pekerjaan
                            </div>
                        </div>
                        <div class="flex">
                            <div class="w-40 py-2">
                                <div class="text-xs font-medium text-center">
                                    Jenis Transaksi
                                </div>
                            </div>
                            <div class="w-40 py-2">
                                <div class="text-xs font-medium text-center">
                                    Volume
                                </div>
                            </div>
                            <div class="w-40 py-2">
                                <div class="text-xs font-medium text-center">
                                    Satuan
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex px-8 border-b border-gray-200 hover:bg-gray-100 hover:cursor-pointer">
                            <div class="py-3.5 grow">
                                <div class="flex items-center gap-2">
                                    <div class="transition-all duration-300 hover:rotate-90 hover:opacity-80">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6.99984 12.8334C10.2215 12.8334 12.8332 10.2217 12.8332 7.00008C12.8332 3.77842 10.2215 1.16675 6.99984 1.16675C3.77818 1.16675 1.1665 3.77842 1.1665 7.00008C1.1665 10.2217 3.77818 12.8334 6.99984 12.8334Z" stroke="black" stroke-width="1.16667"/>
                                            <path d="M6.125 4.66675L8.45833 7.00008L6.125 9.33341" stroke="black" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                    <div class="hidden">
                                        <textarea name="" rows="1" class="p-0 text-sm font-medium border-none focus:ring-0"></textarea>
                                    </div>
                                    <div class="text-sm font-medium h-min hover:text-emerald-700">
                                        Instalasi Air Bersih
                                    </div>
                                    <div class="flex gap-1">
                                        <div class="p-1 rounded fill white bg-emerald-700">
                                            <svg class="w-2.5 h-2.5" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_141_84)">
                                                <path d="M1.80542 6.68668L6.90417 1.58752C7.1056 1.39475 7.37451 1.28852 7.6533 1.29157C7.93209 1.29461 8.19861 1.4067 8.39579 1.60382C8.59296 1.80094 8.70512 2.06743 8.70824 2.34622C8.71137 2.62501 8.60521 2.89394 8.4125 3.09543L3.31292 8.1946C3.19658 8.31094 3.04841 8.39025 2.88708 8.42252L1.25 8.75002L1.5775 7.11252C1.60977 6.95119 1.68907 6.80302 1.80542 6.68668Z" stroke="white" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round"/>
                                                <path d="M6.0415 2.70825L7.2915 3.95825" stroke="white" stroke-width="1.16667"/>
                                                </g>
                                                <defs>
                                                <clipPath id="clip0_141_84">
                                                <rect width="10" height="10" fill="white"/>
                                                </clipPath>
                                                </defs>
                                            </svg>
                                        </div>
                                        <div class="p-1 bg-red-700 rounded fill white">
                                            <svg class="w-2.5 h-2.5" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M0.833496 2.49992H9.16683M4.16683 4.58325V6.66659M5.8335 4.58325V6.66659M1.66683 2.49992H8.3335L7.67516 8.42492C7.6526 8.62882 7.55561 8.81724 7.40277 8.95409C7.24993 9.09094 7.05198 9.1666 6.84683 9.16659H3.1535C2.94834 9.1666 2.7504 9.09094 2.59756 8.95409C2.44472 8.81724 2.34773 8.62882 2.32516 8.42492L1.66683 2.49992ZM3.06058 1.31117C3.12798 1.16824 3.23462 1.04742 3.36808 0.962798C3.50154 0.878179 3.65631 0.83325 3.81433 0.833252H6.186C6.34409 0.833171 6.49895 0.878063 6.63248 0.962687C6.76602 1.04731 6.87274 1.16817 6.94016 1.31117L7.50016 2.49992H2.50016L3.06058 1.31117Z" stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden">
                            <div class="flex pl-16 pr-8 border-b border-gray-200 hover:bg-gray-100 hover:cursor-pointer table-header">
                                <div class="py-2 grow">
                                    <div class="text-sm font-medium">
                                        Sub Paket Pekerjaan
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
                        </div>
                    </div>
                </div>
            </div>
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
