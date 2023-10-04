<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import { ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Modal from '@/Components/Modal.vue';

defineProps({
    errors: Object,
    projects: Object
})
const form = useForm({
    name: '',
    client_name: '',
    client_telephone: '',
})
const showCreateModal = ref(false)
const closeCreateModal = () => {
    showCreateModal.value = false
    form.reset()
}
</script>

<template>
    <Head title="Project" />
    <AuthenticatedLayout>
        <template #sidebar>
            <nav class="flex px-5 py-6 border-r w-72 bg-emerald-700 border-emerald-600">
                <div class="flex flex-col w-full">
                    <h2 class="mb-3 text-2xl font-medium text-white">
                        Projects
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
                        <Link :href="route('project.show', projects.data[0].id)"
                            class="flex gap-3 px-3 py-2 text-lg font-medium text-white rounded-lg fill-white bg-emerald-600 hover:bg-opacity-80"
                            :class="route().current('project.show') ? 'bg-amber-500' : 'bg-emerald-600 hover:bg-opacity-80'">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="auto" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4 10.5C3.17 10.5 2.5 11.17 2.5 12C2.5 12.83 3.17 13.5 4 13.5C4.83 13.5 5.5 12.83 5.5 12C5.5 11.17 4.83 10.5 4 10.5ZM4 4.5C3.17 4.5 2.5 5.17 2.5 6C2.5 6.83 3.17 7.5 4 7.5C4.83 7.5 5.5 6.83 5.5 6C5.5 5.17 4.83 4.5 4 4.5ZM4 16.5C3.17 16.5 2.5 17.18 2.5 18C2.5 18.82 3.18 19.5 4 19.5C4.82 19.5 5.5 18.82 5.5 18C5.5 17.18 4.83 16.5 4 16.5ZM8 19H20C20.55 19 21 18.55 21 18C21 17.45 20.55 17 20 17H8C7.45 17 7 17.45 7 18C7 18.55 7.45 19 8 19ZM8 13H20C20.55 13 21 12.55 21 12C21 11.45 20.55 11 20 11H8C7.45 11 7 11.45 7 12C7 12.55 7.45 13 8 13ZM7 6C7 6.55 7.45 7 8 7H20C20.55 7 21 6.55 21 6C21 5.45 20.55 5 20 5H8C7.45 5 7 5.45 7 6Z" />
                            </svg>
                            List Project
                        </Link>
                    </div>
                </div>
            </nav>
        </template>

        <div class="grid gap-2 lg:grid-cols-3 2xl:grid-cols-4">
            <template v-if="projects.data">
                <div @click="router.get(route('project.show', project.id))"
                    class="p-4 py-3 bg-white border rounded-lg shadow card hover:cursor-pointer"
                    v-for="project in projects.data" :key="project.id">
                    <h4 class="flex items-center gap-2 mb-2 text-lg font-medium">
                        <svg class="w-6 h-6" viewBox="0 0 22 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19.25 17.9167V11.7448C19.25 11.2474 19.1488 10.7553 18.9526 10.2983C18.7564 9.8413 18.4693 9.42899 18.1087 9.08645L12.2632 3.5342C11.9224 3.21051 11.4704 3.03003 11.0005 3.03003C10.5305 3.03003 10.0785 3.21051 9.73775 3.5342L3.89125 9.08645C3.53068 9.42899 3.24357 9.8413 3.04737 10.2983C2.85117 10.7553 2.75 11.2474 2.75 11.7448V17.9167C2.75 18.4029 2.94315 18.8692 3.28697 19.2131C3.63079 19.5569 4.0971 19.75 4.58333 19.75H17.4167C17.9029 19.75 18.3692 19.5569 18.713 19.2131C19.0568 18.8692 19.25 18.4029 19.25 17.9167Z"
                                stroke="black" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M8.25 14.2501C8.25 13.7639 8.44315 13.2975 8.78697 12.9537C9.13079 12.6099 9.5971 12.4167 10.0833 12.4167H11.9167C12.4029 12.4167 12.8692 12.6099 13.213 12.9537C13.5568 13.2975 13.75 13.7639 13.75 14.2501V19.7501H8.25V14.2501Z"
                                stroke="black" stroke-width="1.16667" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        {{ project.name }}
                    </h4>
                    <div class="flex flex-row items-center gap-1 text-sm font-light">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                            <path fill-rule="evenodd"
                                d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ project.client_name }}
                    </div>
                    <div class="pt-3 mt-8 border-t border-black/50">
                        <span class="block mb-2 font-medium">Batas Penggunaan</span>
                        <div class="relative w-full h-3 mb-1 overflow-hidden bg-gray-300 rounded">
                            <div class="absolute inset-0 w-1/12 h-full bg-emerald-700"></div>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-xs font-normal">Rp. 1.000.000 dari Rp. 10.000.000</span>
                            <span class="text-xs font-normal">10%</span>
                        </div>
                    </div>
                </div>
            </template>
            <div @click="showCreateModal = true"
                class="flex flex-col p-4 py-3 text-center transition-all duration-200 border rounded-lg shadow card opacity-60 hover:opacity-100 hover:cursor-pointer">
                <svg class="w-24 h-full mx-auto" viewBox="0 0 106 105" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M53 35V52.5M53 52.5V70M53 52.5H70.5M53 52.5H35.5" stroke="#E7E5E4" stroke-width="6"
                        stroke-linecap="round" />
                    <path
                        d="M53 96.25C77.1625 96.25 96.75 76.6625 96.75 52.5C96.75 28.3375 77.1625 8.75 53 8.75C28.8375 8.75 9.25 28.3375 9.25 52.5C9.25 76.6625 28.8375 96.25 53 96.25Z"
                        stroke="#E7E5E4" stroke-width="6" />
                </svg>
                <h4 class="text-lg font-medium text-gray-400">Tambah Pekerjaan Baru</h4>
            </div>
        </div>

        <Modal :show="showCreateModal" @close="closeCreateModal">
            <form @submit.prevent="form.post(route('project.store'), {
                onSuccess: () => {
                    closeCreateModal()
                    form.reset()
                }
            })">
                <div class="flex justify-between p-4 border-b">
                    <h5 class="text-base font-semibold">
                        Buat Proyek Baru
                    </h5>
                    <button type="button" @click="closeCreateModal">
                        ❌
                    </button>
                </div>
                <div class="px-4 py-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="w-full col-span-2 md:w-2/3">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 after:content-['*'] after:text-red-500">
                                Nama
                            </label>
                            <input type="text" v-model="form.name"
                                class="block w-full p-0 text-2xl text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                placeholder="Nama proyek atau jasa" required>
                            <template v-if="errors.name">
                                <span class="text-sm text-red-500">{{ errors.name }}</span>
                            </template>
                        </div>
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                                Nama Klien
                            </label>
                            <input type="text" v-model="form.client_name"
                                class="block w-full p-0 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                placeholder="Nama customer">
                            <template v-if="errors.client_name">
                                <span class="text-sm text-red-500">{{ errors.client_name }}</span>
                            </template>
                        </div>
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                                Nomor Telepon
                            </label>
                            <input type="text" v-model="form.client_telephone"
                            class="block w-full p-0 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                            placeholder="08xxx">
                        <template v-if="errors.client_telephone">
                            <span class="text-sm text-red-500">{{ errors.client_telephone }}</span>
                        </template>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t">
                <PrimaryButton type="submit" :disabled="form.processing">Simpan</PrimaryButton>
            </div>
        </form>
    </Modal>
</AuthenticatedLayout></template>
