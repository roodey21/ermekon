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

defineOptions({
    layout: AuthenticatedLayout,
})
</script>

<template>
    <Head title="Project" />

    <div class="flex flex-row justify-between p-4 bg-teal-700 shadow">
        <div class="flex items-center gap-3">
            <h3 class="text-white">
                Proyek / Overview
            </h3>
            <div class="w-[1px] bg-white/50 h-6">

            </div>
            <button type="button" @click="showCreateModal=true" class="flex items-center text-white py-0.5 px-1 gap-1 text-xs font-medium rounded bg-teal-800">
                <svg class="w-2.5 h-2.5" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.99984 8.33341V5.00008M4.99984 5.00008V1.66675M4.99984 5.00008H8.33317M4.99984 5.00008H1.6665" stroke="white" stroke-width="1.16667" stroke-linecap="round"/>
                </svg>
                Proyek Baru
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

    <div class="grid gap-2 px-5 py-8 lg:grid-cols-3 2xl:grid-cols-4">
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
                        <div class="absolute inset-0 w-1/12 h-full bg-teal-700"></div>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-xs font-normal">Rp. 1.000.000 dari Rp. 10.000.000</span>
                        <span class="text-xs font-normal">10%</span>
                    </div>
                </div>
            </div>
        </template>
        <!-- <div @click="showCreateModal = true"
            class="flex flex-col p-4 py-3 text-center transition-all duration-200 border rounded-lg shadow card opacity-60 hover:opacity-100 hover:cursor-pointer">
            <svg class="w-24 h-full mx-auto" viewBox="0 0 106 105" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M53 35V52.5M53 52.5V70M53 52.5H70.5M53 52.5H35.5" stroke="#E7E5E4" stroke-width="6"
                    stroke-linecap="round" />
                <path
                    d="M53 96.25C77.1625 96.25 96.75 76.6625 96.75 52.5C96.75 28.3375 77.1625 8.75 53 8.75C28.8375 8.75 9.25 28.3375 9.25 52.5C9.25 76.6625 28.8375 96.25 53 96.25Z"
                    stroke="#E7E5E4" stroke-width="6" />
            </svg>
            <h4 class="text-lg font-medium text-gray-400">Tambah Pekerjaan Baru</h4>
        </div> -->
    </div>

    <Modal :show="showCreateModal" @close="closeCreateModal">
        <form @submit.prevent="form.post(route('project.store'), {
            onSuccess: () => {
                closeCreateModal()
                form.reset()
            }
        })">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-100 border-b">
                <h5 class="text-sm font-medium">
                    Buat Proyek Baru
                </h5>
                <button type="button" @click="closeCreateModal" class="p-[2px] rounded bg-white border">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="px-4 py-6">
                <div class="mb-2">
                    <input type="text"
                        class="w-full p-2 -ml-2 text-2xl font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                        v-model="form.name"
                        placeholder="Nama Proyek">
                </div>
                <div class="mb-2">
                    <div class="flex flex-row gap-2">
                        <div class="flex-1">
                            <label for="name"
                                class="block text-xs font-medium text-gray-900 after:content-['*'] after:text-red-500 mb-1">
                                Nama Kustomer
                            </label>
                            <input type="text"
                                class="w-full px-2 py-1.5 -ml-2 text-sm font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                                v-model="form.client_name"
                                placeholder="Nama Kustomer">
                        </div>
                        <div class="flex-1">
                            <label for="name"
                                class="block text-xs font-medium text-gray-900 after:content-['*'] after:text-red-500 mb-1">
                                Telepon Kustomer
                            </label>
                            <input type="text"
                                class="w-full px-2 py-1.5 -ml-2 text-sm font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                                v-model="form.client_telephone"
                                placeholder="Nomor Telepon">
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <textarea
                        rows="8"
                        class="w-full p-2 -mx-2 text-sm font-light text-gray-900 border border-gray-200 border-opacity-0 rounded placeholder:text-gray-400 focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                        placeholder="Deskripsi atau catatan lainnya ditulis disini"
                        v-model="form.description"></textarea>
                </div>
            </div>
            <div class="p-4 border-t">
                <PrimaryButton type="submit" :disabled="form.processing">Simpan</PrimaryButton>
            </div>
        </form>
    </Modal>
</template>
