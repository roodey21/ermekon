<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import { Head, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const selectedItems = ref([])
const isAllSelected = ref(false)

const selectAll = () => {
    selectedItems.value = []
    if(!isAllSelected.value) {
        console.log(units.data)
        units.data.forEach((unit) => {
            selectedItems.value.push(unit.id)
        })
    }
    isAllSelected.value = !isAllSelected.value
}
const deleteSelectedItems = () => {
    if (confirm('Apakah anda yakin ingin menghapus data ini?')) {
        router.delete(route('unit.mass-destroy', {'ids' :selectedItems.value}))
    }
    selectedItems.value = []
}
const { units } = defineProps({
    units: {
        type: Object
    }
})
watch(() => isAllSelected, (value) => {
    if (value.length === 0) {
        isAllSelected.value = false;
    } else if (value.length === this.users.length) {
        isAllSelected.value = true;
    } else {
        isAllSelected.value = false;
    }
})
</script>

<template>
    <Head title="List Satuan" />

    <AuthenticatedLayout>
        <div class="flex gap-4 px-4 py-3 bg-white border-b">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Satuan</h2>
            <PrimaryButton @click="router.get(route('unit.create'))">
                Baru
            </PrimaryButton>
            <PrimaryButton @click="router.get(route('unit.show-import-form'))">
                Import data
            </PrimaryButton>
            <template v-if="selectedItems.length">
                <DangerButton @click="deleteSelectedItems">
                    Hapus data yang dipilih
                </DangerButton>
            </template>
        </div>

        <div class="mx-auto">
            <div class="overflow-hidden bg-white shadow-sm">
                <div class="relative overflow-x-auto max-h-[90vh] shadow-md">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">
                                    <div class="flex items-center">
                                        <input v-model="isAllSelected" @click="selectAll" id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                    </div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Satuan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="units.data.length">
                                <tr v-for="(unit) in units.data" :key="unit.id" class="bg-white border-b hover:bg-gray-50">
                                    <td class="w-4 px-4 py-2">
                                        <div class="flex items-center">
                                            <input v-model="selectedItems" :value="unit.id" id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap hover:cursor-pointer" @click="router.get(route('unit.edit',unit.id))">
                                        {{ unit.name }}
                                    </th>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="2" class="px-4 py-2 font-medium capitalize">Belum ada satuan yang ditambahkan</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

