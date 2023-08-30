<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'
</script>

<template>
    <Head title="Project"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-row justify-between">
                <div class="flex flex-col">
                    <h5 class="text-lg font-semibold">
                        Project Summary
                    </h5>
                    <div>
                        <Link :href="route('project.create')" class="px-2 py-1 text-sm font-semibold text-white bg-stone-700">Baru</Link>
                    </div>
                </div>
                <div class="flex items-center w-full max-w-xs gap-2 border rounded h-min border-stone-400">
                    <span>🔎</span>
                    <input type="text" class="w-full px-2 py-1 text-sm font-semibold border-0 placeholder:text-sm" placeholder="Cari disini ...">
                </div>
            </div>

        </template>

    </AuthenticatedLayout>
</template>
