<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, router, useForm } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'

defineProps({
    errors: Object
})
const form = useForm({
    file: null,
})
const submit = () => {
    form.post(route('unit.import'))
}
</script>

<template>
    <Head title="Import produk" />

    <AuthenticatedLayout>
        <div class="flex flex-col min-h-screen md:flex-row border-y">
            <div class="md:border-r-2 basis-full md:basis-2/3">
                <div class="sticky px-4 py-3 bg-white top-14 basis-2/3">
                    <div class="flex flex-row items-center justify-between">
                        <span>Satuan / Import</span>
                    </div>
                </div>
                <div class="p-4">
                    <!-- Card -->
                    <form @submit.prevent="submit">
                        <div class="bg-white border">
                            <div class="flex flex-row justify-between px-4 py-2 border-b">
                                <div></div>
                                <div class="flex gap-2 glex-row">
                                    <SecondaryButton @click="router.get(route('unit.index'))">
                                        Kembali
                                    </SecondaryButton>
                                    <PrimaryButton type="submit">
                                        Upload File
                                    </PrimaryButton>
                                </div>
                            </div>
                            <div class="px-8 py-6">
                                <div class="mb-4 md:mb-6">
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                                        Pilih File
                                    </label>
                                    <div class="flex items-center justify-center w-full">
                                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100">
                                            <template v-if="form.file">
                                                <div class="flex flex-row gap-2 items-center justify-center pt-5 pb-6">
                                                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                                        <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"/>
                                                        <path d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2Z"/>
                                                    </svg>
                                                    <p class="text-sm text-gray-500"><span class="font-semibold">{{ form.file.name }}</span></p>
                                                </div>
                                            </template>
                                            <template v-else>
                                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                    <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                    </svg>
                                                    <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span></p>
                                                    <p class="text-xs text-gray-500">XLSX, CSV, XML (max: 1024kb)</p>
                                                </div>
                                            </template>
                                            <input id="dropzone-file" type="file" @input="form.file = $event.target.files[0]" class="hidden" />
                                        </label>
                                    </div>
                                    <!-- <input type="file" @input="form.file = $event.target.files[0]"
                                        class="border-x-0 border-t-0 border-gray-300 hover:border-gray-600 focus:border-gray-600 text-gray-900 text-sm block w-full p-2.5 focus:ring-0"> -->
                                    <template v-if="errors.name">
                                        <span class="text-sm text-red-500">{{ errors.file }}</span>
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

<style>

</style>
