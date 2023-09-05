<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import { router, Head } from '@inertiajs/vue3';
import { ref } from 'vue'

const props = defineProps({
    tasks: Object,
})

const isAllSelected = ref(false)
const selectedItems = ref([])
const selectAll = () => {
    selectedItems.value = []
    if (!isAllSelected.value) {
        props.tasks.data.forEach((task) => {
            selectedItems.value.push(task.id)
        })
    }
    isAllSelected.value = !isAllSelected.value
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="sticky z-10 flex gap-4 px-4 py-3 bg-white border-b top-12">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Product</h2>
            <PrimaryButton @click="router.get(route('product.create'))">
                Tugas Baru
            </PrimaryButton>
            <!-- <PrimaryButton @click="router.get(route('product.import'))">
                Import data
            </PrimaryButton>
            <template v-if="selectedItems.length">
                <DangerButton @click="deleteSelectedItems">
                    Hapus data yang dipilih
                </DangerButton>
            </template> -->
        </div>

        <div class="mx-auto">
            <div class="h-full overflow-hidden bg-white shadow-sm">
                <div class="relative overflow-x-auto shadow-md">
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
                            <template v-if="tasks.data.length">
                                <tr v-for="task in tasks.data" :key="task.id" class="bg-white border-b hover:bg-gray-50">
                                    <td class="w-4 px-4 py-2">
                                        <div class="flex items-center">
                                            <input v-model="selectedItems" :value="task.id" id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap hover:cursor-pointer">
                                        {{ task.name }}
                                    </th>
                                    <td class="px-6 py-2">
                                        <!-- {{ task.code }} -->
                                    </td>
                                    <td class="px-6 py-2">
                                        <!-- {{ task.type.name }} -->
                                    </td>
                                    <td class="px-6 py-2">
                                        <!-- {{ task.main_unit.name }} -->
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="4" class="px-4 py-2 font-medium capitalize">Belum ada tugas yang dibuat</td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
