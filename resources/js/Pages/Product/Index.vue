<script setup>
import { Head, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    products: {
        type: Object
    }
})
</script>

<template>
    <Head title="List Product" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Product</h2>
                <button class="px-4 py-1 bg-gray-100">Simpan</button>
            </div>
        </template>

        <div class="mx-auto">
            <div class="overflow-hidden bg-white shadow-sm">
                <div class="relative overflow-x-auto shadow-md">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">
                                    <div class="flex items-center">
                                        <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Barang
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Kode Barang
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Kategori
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Satuan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr @click="router.get(route('product.edit',product.id))" v-for="product in products.data" :key="product.id" class="bg-white border-b hover:bg-gray-50 hover:cursor-pointer">
                                <td class="w-4 px-4 py-2">
                                    <div class="flex items-center">
                                        <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                        <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                    </div>
                                </td>
                                <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap">
                                    {{ product.name }}
                                </th>
                                <td class="px-6 py-2">
                                    {{ product.code }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ product.category.name }}
                                </td>
                                <td class="px-6 py-2">
                                    {{ product.main_unit_name }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<style>

</style>
