<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import { Head, Link, router, useForm } from '@inertiajs/vue3'

const { unit } = defineProps({
    unit: Object,
    errors: Object
})
const form = useForm({
    name: unit.data.name,
})
const deleteUnit = (id) => {
    if (confirm('Apakah anda yakin ingin menghapus data ini?')) {
        form.delete(route('unit.destroy', id))
    }
}
defineOptions({
    layout: AuthenticatedLayout
})
</script>

<template>
    <Head title="Edit Satuan" />

    <div class="flex flex-col min-h-screen md:flex-row border-y">
        <div class="md:border-r-2 basis-full md:basis-2/3">
            <div class="p-4 pb-0">
                <div class="flex flex-col justify-between gap-4 mb-4 md:flex-row">
                    <div class="flex flex-col">
                        <div class="flex items-center justify-between gap-3 md:justify-start">
                            <h3 class="text-xl font-semibold capitalize">
                                {{ unit.data.name }}
                            </h3>
                        </div>
                        <ul class="flex items-center gap-1.5 breadcrumbs">
                            <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                                <Link :href="route('dashboard')" >Dashboard</Link>
                            </li>
                            <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                                <Link :href="route('unit.index')">Satuan</Link>
                            </li>
                            <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                                Edit Satuan
                            </li>
                        </ul>
                    </div>
                    <div class="flex flex-row justify-end max-w-md gap-2 grow">

                    </div>
                </div>
            </div>
            <!-- <div class="sticky px-4 py-3 bg-white top-14 basis-2/3">
                <div class="flex flex-row items-center justify-between">
                    <span>Satuan / Edit</span>
                    <DangerButton @click="deleteUnit(unit.data.id)">
                        Hapus
                    </DangerButton>
                </div>
            </div> -->
            <div class="p-4">
                <!-- Card -->
                <form @submit.prevent="form.put(route('unit.update', unit.data.id))">
                    <div class="bg-white border">
                        <div class="flex flex-row justify-between px-4 py-2 border-b">
                            <div></div>
                            <div class="flex gap-2 glex-row">
                                <SecondaryButton @click="router.get(route('unit.index'))">
                                    Kembali
                                </SecondaryButton>
                                <PrimaryButton type="submit">
                                    Simpan
                                </PrimaryButton>
                            </div>
                        </div>
                        <div class="px-8 py-6">
                            <div class="mb-4 md:mb-6">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                                    Nama Satuan
                                </label>
                                <input type="text" v-model="form.name"
                                    class="border-x-0 border-t-0 border-gray-300 hover:border-gray-600 focus:border-gray-600 text-gray-900 text-sm block w-full p-2.5 focus:ring-0"
                                    placeholder="Nama Satuan" required>
                                <template v-if="errors.name">
                                    <span class="text-sm text-red-500">{{ errors.name }}</span>
                                </template>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="bg-white basis-full md:basis-1/3">
            <div class="sticky top-0 px-4 py-3 bg-white basis-2/3">
                <div class="flex flex-row items-center justify-between">
                    <PrimaryButton>
                        Kirim Pesan
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </div>
</template>
