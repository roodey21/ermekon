<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router, useForm } from '@inertiajs/vue3'
import { computed, ref } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import CreateProjectModal from './Partials/CreateProjectModal.vue'
import { BarsArrowDownIcon, MagnifyingGlassIcon } from '@heroicons/vue/24/outline';

const createProjectModal = ref(null)

const openCreateModal = () => {
    createProjectModal.value.openModal()
}

defineProps({
    errors: Object,
    projects: Object
})

defineOptions({
    layout: AuthenticatedLayout,
})
</script>

<template>
    <Head title="Project" />

    <div class="p-4">
        <div class="flex flex-col justify-between gap-4 mb-4 md:flex-row">
            <div class="flex flex-col">
                <div class="flex items-center justify-between gap-3 md:justify-start">
                    <h3 class="text-xl font-semibold capitalize">
                        Manajement Proyek
                    </h3>
                    <button type="button" @click="openCreateModal" class="flex items-center text-white py-0.5 px-1 gap-1 text-xs font-medium rounded bg-teal-800">
                        <svg class="w-2.5 h-2.5" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.99984 8.33341V5.00008M4.99984 5.00008V1.66675M4.99984 5.00008H8.33317M4.99984 5.00008H1.6665" stroke="white" stroke-width="1.16667" stroke-linecap="round"/>
                        </svg>
                        Proyek Baru
                    </button>
                </div>
                <ul class="flex items-center gap-1.5 breadcrumbs">
                    <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                        <Link :href="route('dashboard')" >Dashboard</Link>
                    </li>
                    <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                        List Proyek
                    </li>
                </ul>
            </div>
            <div class="flex flex-row justify-end max-w-md gap-2 grow">
                <div class="">
                    <button class="flex items-center px-2 py-1.5 text-sm text-white bg-teal-700 rounded-lg">
                        <BarsArrowDownIcon class="w-4 h-4 mr-1" />
                        Filter
                    </button>
                </div>
                <div class="flex items-center w-full max-w-xs overflow-hidden bg-white border rounded-lg h-min border-stone-400">
                    <span class="px-2 py-1.5">
                        <MagnifyingGlassIcon class="w-4 h-4" />
                    </span>
                    <input type="text" class="w-full px-2 py-1.5 text-sm border-0 placeholder:text-sm" placeholder="Cari disini ...">
                </div>
            </div>
        </div>
        <div class="grid gap-y-6 gap-x-3 lg:grid-cols-3 2xl:grid-cols-4">
            <template v-if="projects.data">
                <div @click="router.get(route('project.overview', project.id))"
                    class="p-4 py-3 bg-white border rounded-lg shadow card hover:cursor-pointer"
                    v-for="project in projects.data" :key="project.id">
                    <h4 class="flex items-center gap-2 mb-2 text-lg font-medium">
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
            <template v-else>
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
            </template>
        </div>
    </div>

    <CreateProjectModal ref="createProjectModal" />
</template>
