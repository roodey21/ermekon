<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import InputUnit from '@/Components/InputUnit.vue';

defineProps({
    product: {
        type: Object,
    },
    categories: {
        type: Object,
    },
});
</script>

<template>
    <Head title="Edit Product" />

    <AuthenticatedLayout>
        <div class="flex flex-row border-y">
            <div class="basis-2/3">
                <div class="px-4 py-3 bg-white border-r-2 basis-2/3">
                    <div class="flex flex-row items-center justify-between">
                        <span>Produk / Baru</span>
                        <Link :href="route('product.create')" class="py-1.5 px-2 text-sm bg-white border hover:text-white border-green-600 text-green-700 font-medium hover:bg-green-700">
                            Baru
                        </Link>
                    </div>

                </div>
                <div class="p-4">
                    <!-- Card -->
                    <div class="px-8 py-6 bg-white border">
                        <form>
                            <div class="mb-6">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama Produk</label>
                                <input type="email" id="email" v-model="product.data.name" class="border-x-0 border-t-0 border-transparent hover:border-gray-300 focus:border-gray-600 text-gray-900 text-3xl block w-full p-2.5 focus:ring-0" placeholder="Nama Produk, contoh: batu akik kaki lima" required>
                            </div>
                            <div class="grid grid-cols-2 gap-4 py-4">
                                <div class="flex flex-col gap-4">
                                    <div class="grid grid-cols-5 align-center">
                                        <div class="flex items-center">
                                            <label for="" class="text-sm font-medium">Tipe Produk</label>
                                        </div>
                                        <div class="col-span-4">
                                            <select v-model="product.data.category.id" class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-transparent border-x-0 hover:border-gray-300 focus:border-gray-600 focus:ring-0">
                                                <option value="category.id" v-for="category in categories" :selected="product.data.category.id == category.id" :key="category.id">{{ category.name }}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-5 align-center">
                                        <div class="flex items-center">
                                            <label for="" class="text-sm font-medium">Satuan</label>
                                        </div>
                                        <div class="col-span-4">
                                            <InputUnit/>
                                        </div>
                                    </div>

                                </div>
                                <div class="flex flex-col gap-4">
                                    <div class="grid grid-cols-5 align-center">
                                        <div class="flex items-center gap-4">
                                            <label for="" class="text-sm font-medium">Kode</label> <input type="checkbox" name="" id="" class="rounded focus:ring-0">
                                        </div>
                                        <div class="col-span-4">
                                            <input id="" disabled class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-transparent disabled:bg-gray-100 border-x-0 hover:border-gray-300 focus:border-gray-600 focus:ring-0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="basis-1/3">

            </div>
        </div>

    </AuthenticatedLayout>
</template>
