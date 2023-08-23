<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import { Head, router, useForm } from '@inertiajs/vue3'

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
</script>

<template>
    <Head title="Edit Satuan" />

    <AuthenticatedLayout>
        <div class="flex flex-col min-h-screen md:flex-row border-y">
            <div class="md:border-r-2 basis-full md:basis-2/3">
                <div class="sticky px-4 py-3 bg-white top-14 basis-2/3">
                    <div class="flex flex-row items-center justify-between">
                        <span>Satuan / Edit</span>
                        <DangerButton @click="deleteUnit(unit.data.id)">
                            Hapus
                        </DangerButton>
                    </div>
                </div>
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
                <div class="sticky px-4 py-3 bg-white basis-2/3 top-14">
                    <div class="flex flex-row items-center justify-between">
                        <PrimaryButton>
                            Kirim Pesan
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
