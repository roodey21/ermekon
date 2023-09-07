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
    <Head title="Project"/>

    <AuthenticatedLayout>
        <div class="flex flex-row justify-between px-4 py-3 bg-white border-b shadow-sm">
            <div class="flex flex-col">
                <h5 class="text-lg font-semibold">
                    Project Summary
                </h5>
                <div>
                    <button @click="showCreateModal = true" class="px-2 py-1 text-sm font-semibold text-white bg-stone-700">Baru</button>
                </div>
            </div>
            <div class="flex items-center w-full max-w-xs gap-2 border rounded h-min border-stone-400">
                <span>🔎</span>
                <input type="text" class="w-full px-2 py-1 text-sm font-semibold border-0 placeholder:text-sm" placeholder="Cari disini ...">
            </div>
        </div>

        <div class="grid grid-cols-3 gap-2 px-4 py-6">
            <template v-if="projects.data">
                <div @click="router.get(route('project.show', project.id))" class="p-4 py-3 bg-white border card hover:cursor-pointer" v-for="project in projects.data" :key="project.id">
                    <h4 class="mb-2 text-sm font-semibold">{{ project.name }}</h4>
                    <div class="flex flex-row items-center gap-1 text-sm font-light">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3 h-3">
                        <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd" />
                        </svg>
                        {{ project.client_name }}
                    </div>
                    <div class="mt-8">
                        <div class="flex flex-row justify-between">
                            <span class="text-xs font-bold text-emerald-600">{{ `${project.task_count} Tasks` }}</span>
                        </div>
                    </div>
                </div>
            </template>
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
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 after:content-['*'] after:text-red-500">
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
    </AuthenticatedLayout>
</template>
