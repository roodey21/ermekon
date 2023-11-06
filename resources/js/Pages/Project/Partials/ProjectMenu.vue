<script setup>
import { ArrowUturnLeftIcon, ChevronDownIcon, LinkIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline';
import UpdateProjectModal from './UpdateProjectModal.vue';
import Dropdown from '@/Components/Dropdown.vue';
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    project: Object,
})

const updateProjectModal = ref(false)

const openEditProjectModal = () => {
    updateProjectModal.value.openModal()
}
</script>

<template>
    <h3 class="text-xl font-semibold capitalize">
        {{ project.data.name }}
    </h3>
    <Dropdown align="left">
        <template #trigger>
            <div class="hover:cursor-pointer">
                <ChevronDownIcon class="w-4 h-4" />
            </div>
        </template>

        <template #content>
            <ul class="p-1.5 text-black">
                <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded">
                    <Link :href="route('project.index')" class="flex items-center gap-2 text-xs">
                        <ArrowUturnLeftIcon class="w-3 h-3" /> <span>Kembali ke List Proyek</span>
                    </Link>
                </li>
                <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded"
                    @click="openEditProjectModal">
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

    <UpdateProjectModal :project="project" ref="updateProjectModal"/>
</template>
