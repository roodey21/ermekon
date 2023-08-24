<script setup>
import { Head, router, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { ref } from 'vue';
import { watch } from 'vue';

const { products } = defineProps({
    products: {
        type: Object
    }
})
const selectedItems = ref([])
const isAllSelected = ref(false)

const selectAll = () => {
    selectedItems.value = []
    if(!isAllSelected.value) {
        products.data.forEach((product) => {
            selectedItems.value.push(product.id)
        })
    }
    isAllSelected.value = !isAllSelected.value
}
const deleteForm = useForm({
    ids: selectedItems.value
})

const deleteSelectedItems = () => {
    if (confirm('Apakah anda yakin ingin menghapus data ini?')) {
        deleteForm.delete(route('product.mass-destroy'))
    }
    selectedItems.value = []
}
watch(() => isAllSelected, (value) => {
    if (value.length === 0) {
        isAllSelected = false;
    } else if (value.length === products.length) {
        isAllSelected = true;
    } else {
        isAllSelected = false;
    }
})
watch(selectedItems, (value) => {
    deleteForm.ids = value
})
</script>

<template>
    <Head title="List Product" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex gap-4">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">Product</h2>
                <PrimaryButton @click="router.get(route('product.create'))">
                    Baru
                </PrimaryButton>
                <PrimaryButton @click="router.get(route('product.import'))">
                    Import data
                </PrimaryButton>
                <template v-if="selectedItems.length">
                    <DangerButton @click="deleteSelectedItems">
                        Hapus data yang dipilih
                    </DangerButton>
                </template>
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
                                        <input v-model="isAllSelected" @click="selectAll" id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
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
                                    Tipe Barang
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Satuan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="products.data.length">
                                <tr v-for="product in products.data" :key="product.id" class="bg-white border-b hover:bg-gray-50">
                                    <td class="w-4 px-4 py-2">
                                        <div class="flex items-center">
                                            <input v-model="selectedItems" :value="product.id" id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap hover:cursor-pointer" @click="router.get(route('product.edit',product.id))">
                                        {{ product.name }}
                                    </th>
                                    <td class="px-6 py-2">
                                        {{ product.code }}
                                    </td>
                                    <td class="px-6 py-2">
                                        {{ product.type.name }}
                                    </td>
                                    <td class="px-6 py-2">
                                        {{ product.main_unit.name }}
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="4" class="px-4 py-2 font-medium capitalize">Belum ada produk yang ditambahkan</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>


<style>

</style>
