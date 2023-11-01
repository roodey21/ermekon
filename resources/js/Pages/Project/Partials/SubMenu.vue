<script setup>
import { ArrowPathRoundedSquareIcon, CheckCircleIcon, ChevronLeftIcon, ChevronRightIcon, DocumentIcon, FolderIcon, NewspaperIcon, TableCellsIcon } from '@heroicons/vue/24/outline';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    project: {
        type: Object,
        required: true,
    },
    className: {
        type: String,
        default: ''
    }
})
</script>

<template>
<Head title="Task" />
<div :class="className">
    <div class="flex flex-row justify-between w-full gap-2 p-4 overflow-x-auto bg-white border rounded-lg shadow">
        <!-- <div class="flex items-center py-1 mr-2">
            <ChevronLeftIcon class="w-4 h-4" />
        </div> -->
        <div class="flex gap-2 grow">
            <Link :href="route('project.overview', project.data.id)" class="flex items-center whitespace-nowrap gap-1.5 px-2 py-1 text-sm font-medium text-gray-600 transition-all border-b-2 border-opacity-0 border-teal-700 hover:cursor-pointer hover:border-opacity-100" :class="{ 'border-opacity-100 ' : route().current('project.overview') }">
                <TableCellsIcon class="w-4 h-4"/> Overview
            </Link>
            <Link :href="route('project.show', project.data.id)" class="flex items-center whitespace-nowrap gap-1.5 px-2 py-1 text-sm font-medium text-gray-600 transition-all border-b-2 border-teal-700 border-opacity-0 hover:border-opacity-100 hover:cursor-pointer" :class="{ 'border-opacity-100 ' : route().current('project.show') }">
                <DocumentIcon class="w-4 h-4" /> BoQ
            </Link>
            <Link :href="route('project.task.index', project.data.id)" class="flex items-center whitespace-nowrap gap-1.5 px-2 py-1 text-sm font-medium text-gray-600 transition-all border-b-2 border-teal-700 border-opacity-0 hover:border-opacity-100 hover:cursor-pointer" :class="{ 'border-opacity-100 ' : route().current('project.task.index') }">
                <CheckCircleIcon class="w-4 h-4" /> Tasks
            </Link>
            <div class="flex items-center whitespace-nowrap gap-1.5 px-2 py-1 text-sm font-medium text-gray-600 transition-all border-b-2 border-teal-700 border-opacity-0 hover:border-opacity-100 hover:cursor-pointer">
                <FolderIcon class="w-4 h-4" /> Files
            </div>
            <div class="flex items-center whitespace-nowrap gap-1.5 px-2 py-1 text-sm font-medium text-gray-600 transition-all border-b-2 border-teal-700 border-opacity-0 hover:border-opacity-100 hover:cursor-pointer">
                <NewspaperIcon class="w-4 h-4" /> Expenses
            </div>
            <div class="flex items-center whitespace-nowrap gap-1.5 px-2 py-1 text-sm font-medium text-gray-600 transition-all border-b-2 border-teal-700 border-opacity-0 hover:border-opacity-100 hover:cursor-pointer">
                <ArrowPathRoundedSquareIcon class="w-4 h-4" /> Activity Log
            </div>
        </div>
        <!-- <div class="flex items-center py-1 mr-2">
            <ChevronRightIcon class="w-4 h-4" />
        </div> -->
    </div>
</div>
</template>

<style>

</style>
