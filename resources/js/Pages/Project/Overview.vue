<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ArrowUturnLeftIcon, BarsArrowDownIcon, CalendarIcon, CheckCircleIcon, ChevronDownIcon, ChevronLeftIcon, ChevronRightIcon, DocumentIcon, FolderIcon, FunnelIcon, LinkIcon, MagnifyingGlassIcon, PencilSquareIcon, TableCellsIcon, TrashIcon } from '@heroicons/vue/24/outline';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
import SubMenu from './Partials/SubMenu.vue';
import ProjectMenu from './Partials/ProjectMenu.vue';

defineProps({
    project: {
        type: Object,
        required: true
    }
})

const showEditProjectModal = ref(false)
const openEditProjectModal = () => {
    showEditProjectModal.value = true
}

defineOptions({
    layout: AuthenticatedLayout
})
</script>

<template>
  <Head :title="`Project ${project.data.name}`"/>

    <div class="p-4">
        <!-- <div class="flex flex-row justify-between bg-teal-700 shadow">
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
            </div>
            <div class="flex items-center w-full max-w-xs border rounded h-min border-stone-400">
                <span class="px-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </span>
                <input type="text" class="w-full px-2 py-1 text-sm font-semibold border-0 placeholder:text-sm" placeholder="Cari disini ...">
            </div>
        </div> -->
        <div class="flex flex-col justify-between gap-4 mb-4 md:flex-row">
            <div class="flex flex-col">
                <div class="flex items-center gap-1.5">
                    <ProjectMenu :project="project" />
                </div>
                <ul class="flex items-center gap-1.5 breadcrumbs">
                    <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                        <Link :href="route('dashboard')" >Dashboard</Link>
                    </li>
                    <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                        <Link :href="route('project.index')" >Proyek</Link>
                    </li>
                    <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                        Overview
                    </li>
                </ul>
            </div>
            <div class="flex flex-row justify-end max-w-md gap-2 grow">
                <div class="">
                    <button class="flex items-center px-2 py-1.5 text-sm text-white bg-teal-700 rounded-lg">
                        <FunnelIcon class="w-3.5 h-3.5 mr-1" />
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

        <SubMenu :project="project"/>

        <div class="grid grid-cols-2 gap-6 mt-4 md:grid-cols-4">
            <div class="col-span-2" id="project-progress">
                <div class="w-full bg-white border rounded-lg shadow">
                    <div class="px-6 py-4 border-b card-header">
                        <div class="mb-1 text-sm text-gray-700">Project Progress 0.00%</div>
                        <div class="relative h-2 overflow-hidden bg-gray-100 rounded">
                            <div class="absolute inset-0 w-1 bg-teal-700">

                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4">
                        <h6 class="mb-4 text-sm font-semibold text-gray-800">Overview</h6>
                        <div class="grid grid-cols-2 gap-x-4 gap-y-5">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Project #</dt>
                                <dd class="text-sm text-gray-900 font-base">3</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Customer</dt>
                                <dd class="text-sm text-gray-900 font-base">{{ project.data.client_name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="text-sm text-gray-900 font-base">{{ project.data.status ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Date Created</dt>
                                <dd class="text-sm text-gray-900 font-base">{{ project.data.created_at ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Start Date</dt>
                                <dd class="text-sm text-gray-900 font-base">{{ project.data.start_date ?? '-' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Deadline</dt>
                                <dd class="text-sm text-gray-900 font-base">{{ project.data.end_date ?? '-' }}</dd>
                            </div>
                            <div class="col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="text-sm text-gray-900 font-base">{{ project.data.description ?? 'belum ada deskripsi' }}</dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-2">
                <div class="grid grid-cols-2 gap-6">
                    <div class="px-6 py-4 bg-white border rounded-lg shadow">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-base font-medium text-gray-700">
                                1 / 1 Open Task
                            </span>
                            <div>
                                <CheckCircleIcon class="w-8 h-8 text-gray-700" />
                            </div>
                        </div>
                        <div class="mb-1 text-gray-700">0%</div>
                        <div class="relative h-2 overflow-hidden bg-gray-100 rounded">
                            <div class="absolute inset-0 w-0 bg-teal-700">

                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-white border rounded-lg shadow">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-base font-medium text-gray-700">
                                40 Days Left
                            </span>
                            <div>
                                <CalendarIcon class="w-8 h-8 text-gray-700" />
                            </div>
                        </div>
                        <div class="mb-1 text-gray-700">0%</div>
                        <div class="relative h-2 overflow-hidden bg-gray-100 rounded">
                            <div class="absolute inset-0 w-0 bg-teal-700">

                            </div>
                        </div>
                    </div>
                    <div class="col-span-2 px-6 py-4 bg-white border rounded-lg shadow">
                        <div class="grid grid-cols-4 gap-4">
                            <div>
                                <dt class="font-medium text-gray-500">Total Expenses</dt>
                                <dd class="font-semibold text-gray-800">Rp. 0</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-blue-500">Billable Expenses</dt>
                                <dd class="font-semibold text-gray-800">Rp. 0</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-emerald-500">Billed Expenses</dt>
                                <dd class="font-semibold text-gray-800">Rp. 0</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-red-500">Unbilled Expenses</dt>
                                <dd class="font-semibold text-gray-800">Rp. 0</dd>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>

</style>
