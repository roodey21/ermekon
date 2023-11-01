<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import { CloudArrowUpIcon, FunnelIcon, MagnifyingGlassIcon, PlusIcon } from '@heroicons/vue/24/outline'

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

defineOptions({
    layout: AuthenticatedLayout
})
</script>

<template>
    <Head title="List Satuan" />

    <div class="p-4">
        <div class="flex flex-col justify-between gap-4 mb-4 md:flex-row">
            <div class="flex flex-col">
                <div class="flex items-center justify-between gap-3 md:justify-start">
                    <h3 class="text-xl font-semibold capitalize">
                        Master Data Satuan
                    </h3>
                    <button type="button" @click="router.get(route('unit.create'))" class="flex items-center text-white py-0.5 px-1 gap-1 text-xs font-medium rounded bg-teal-800">
                        <PlusIcon class="w-3 h-3" />
                        <span class=" md:inline-block">
                            Satuan Baru
                        </span>
                    </button>
                    <button type="button" @click="router.get(route('unit.import'))" class="flex items-center text-white py-0.5 px-1 gap-1 text-xs font-medium rounded bg-teal-800">
                        <CloudArrowUpIcon class="w-3 h-3" />
                        <span class=" md:inline-block">
                            Import
                        </span>
                    </button>
                </div>
                <ul class="flex items-center gap-1.5 breadcrumbs">
                    <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                        <Link :href="route('dashboard')" >Dashboard</Link>
                    </li>
                    <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                        Satuan
                    </li>
                </ul>
            </div>
            <div class="flex flex-row justify-end max-w-md gap-2 grow">
                <div class="">
                    <button class="flex items-center px-2 py-1.5 text-sm text-white bg-teal-700 rounded-lg">
                        <FunnelIcon class="w-4 h-4 mr-1" />
                        Filter
                    </button>
                </div>
                <div class="flex items-center w-full max-w-xs overflow-hidden bg-white border rounded-lg h-min border-stone-400">
                    <span class="px-2 py-1.5">
                        <MagnifyingGlassIcon class="w-4 h-4" />
                    </span>
                    <input type="text" class="w-full px-2 py-1.5 text-sm border-0 placeholder:text-sm" placeholder="Cari disini ...">
                </div>
            </div>
        </div>
        <!-- <div class="flex gap-4 px-4 py-3 bg-white border-b">
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
        </div> -->

        <div class="mx-auto">
            <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                <div class="relative overflow-x-auto shadow-md max-h-[80vh]">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <!-- <th scope="col" class="px-4 py-3">
                                    <div class="flex items-center">
                                        <input v-model="isAllSelected" @click="selectAll" id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                        <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                    </div>
                                </th> -->
                                <th scope="col" class="px-6 py-3">
                                    Nama Satuan
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="units.data.length">
                                <tr v-for="(unit) in units.data" :key="unit.id" class="bg-white border-b hover:bg-gray-50">
                                    <!-- <td class="w-4 px-4 py-2">
                                        <div class="flex items-center">
                                            <input v-model="selectedItems" :value="unit.id" id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td> -->
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
    </div>
</template>

