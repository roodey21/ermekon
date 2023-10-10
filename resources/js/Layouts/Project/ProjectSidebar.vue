<script setup>
import { Link } from "@inertiajs/vue3";
import axios from "axios";
import { onMounted, onUnmounted, ref, watch } from "vue"

const projects = ref([])

onMounted(async () => {
    await axios.get(route('api.project.index'))
        .then(response => {
            projects.value = response.data
        })
        .catch(error => {
            console.log(error)
        })
})
</script>

<template>
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
                <!-- <Link
                    :href="route('project.show', projects.data[0].id)"
                    class="flex gap-3 px-3 py-2 text-lg font-medium text-white rounded-lg fill-white"
                    :class="route().current('project.show') ? 'bg-amber-500' : 'bg-emerald-600 hover:bg-opacity-80'">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="auto" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M4 10.5C3.17 10.5 2.5 11.17 2.5 12C2.5 12.83 3.17 13.5 4 13.5C4.83 13.5 5.5 12.83 5.5 12C5.5 11.17 4.83 10.5 4 10.5ZM4 4.5C3.17 4.5 2.5 5.17 2.5 6C2.5 6.83 3.17 7.5 4 7.5C4.83 7.5 5.5 6.83 5.5 6C5.5 5.17 4.83 4.5 4 4.5ZM4 16.5C3.17 16.5 2.5 17.18 2.5 18C2.5 18.82 3.18 19.5 4 19.5C4.82 19.5 5.5 18.82 5.5 18C5.5 17.18 4.83 16.5 4 16.5ZM8 19H20C20.55 19 21 18.55 21 18C21 17.45 20.55 17 20 17H8C7.45 17 7 17.45 7 18C7 18.55 7.45 19 8 19ZM8 13H20C20.55 13 21 12.55 21 12C21 11.45 20.55 11 20 11H8C7.45 11 7 11.45 7 12C7 12.55 7.45 13 8 13ZM7 6C7 6.55 7.45 7 8 7H20C20.55 7 21 6.55 21 6C21 5.45 20.55 5 20 5H8C7.45 5 7 5.45 7 6Z" />
                    </svg>
                    List Proyek
                </Link> -->
            </div>
            <div
                class="flex flex-col pt-6 space-y-2 border-t link-group border-emerald-600">
                <h5 class="text-lg text-white">List Proyek</h5>
                <template v-if="projects.data">
                    <Link
                        v-for="project in projects.data"
                        :key="project.id"
                        :href="route('project.show', project.id)"
                        :class="$page.url && route().current('project.show', { project : project.id}) ? 'bg-amber-500' : 'bg-emerald-600 hover:bg-opacity-80'"
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
