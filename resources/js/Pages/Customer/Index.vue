<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { FunnelIcon, MagnifyingGlassIcon, PlusIcon } from '@heroicons/vue/24/outline'
import { ref } from 'vue'
import CreateCustomerModal from './Partials/CreateCustomerModal.vue'

defineProps({
    customers: {
        type: Object
    }
})

const createModal = ref(false)
const createCustomer = () => {
    createModal.value.openModal()
}

defineOptions({
    layout: AuthenticatedLayout
})
</script>

<template>
    <Head title="Master Data User" />

    <div class="p-4">
        <div class="flex flex-col justify-between gap-4 mb-4 md:flex-row">
            <div class="flex flex-col">
                <div class="flex items-center justify-between gap-3 md:justify-start">
                    <h3 class="text-xl font-semibold capitalize">
                        Master Data Kustomer
                    </h3>
                    <button type="button" @click="createCustomer" class="flex items-center text-white py-0.5 px-1 gap-1 text-xs font-medium rounded bg-teal-800">
                        <PlusIcon class="w-3 h-3" />
                        <span class=" md:inline-block">
                            Kustomer Baru
                        </span>
                    </button>
                    <!-- <button type="button" @click="router.get(route('product.import'))" class="flex items-center text-white py-0.5 px-1 gap-1 text-xs font-medium rounded bg-teal-800">
                        <CloudArrowUpIcon class="w-3 h-3" />
                        <span class=" md:inline-block">
                            Import
                        </span>
                    </button> -->
                </div>
                <ul class="flex items-center gap-1.5 breadcrumbs">
                    <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                        <Link :href="route('dashboard')" >Dashboard</Link>
                    </li>
                    <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                        Kustomer
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

        <div class="mx-auto">
            <div class="overflow-hidden bg-white rounded-lg shadow-md">
                <div class="relative overflow-x-auto shadow-md max-h-[80vh]">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Nama Kustomer
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Alamat Email
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Nomor Telepon/WA
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tanggal Dibuat
                                </th>
                                <th scope="col" class="px-6 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <template v-if="customers.data?.length">
                                <tr v-for="customer in customers.data" :key="customer.id" class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-2 font-medium text-gray-900 whitespace-nowrap hover:cursor-pointer" @click="router.get(route('product.edit',product.id))">
                                        {{ customer.name }}
                                    </th>
                                    <td class="px-6 py-2">
                                        {{ customer.email }}
                                    </td>
                                    <td class="px-6 py-2">
                                        {{ customer.phone ?? '-' }}
                                    </td>
                                    <td class="px-6 py-2">
                                        {{ customer.created_at }}
                                    </td>
                                    <td class="px-6 py-2"></td>
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
    </div>
    <CreateCustomerModal ref="createModal"/>
</template>
