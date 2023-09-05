<script setup>
import { Link, router, Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import Modal from '@/Components/Modal.vue'

import { computed, onMounted, ref, watch } from 'vue';

const tabActive = ref(1)

const props = defineProps({
    errors: Object,
    project: Object,
    task: Object,
    products: Object
})
const searchProduct = ref('')

const filteredProducts = computed(() => {
    return props.products.data.filter((product) => {
        return product.name.toLowerCase().includes(searchProduct.value.toLowerCase())
    })
})
watch(searchProduct, (value) => {
    console.log(value)
    router.reload({
        only: ['products'],
        data: {
            search: value
        }
    })
})
const taskPackage = ref([])
const mainPackage = ref([])

const selectedItems = ref([])
watch(selectedItems, (value) => {
    form.products = []
    value.forEach((item) => {
        form.products.push({
            'id': item.id,
            'name': item.name
        })
    })
})
const addProductModal = ref(false)
const showAddProductModal = () => {
    router.reload({ only: ['products']})
    addProductModal.value = true
}
const closeAddProductModal = () => {
    addProductModal.value = false
}
const form = useForm({
    'name': props.task.data.name,
    'employee_name': props.task.data.employee,
    'package_id': props.task.data.package.id,
    'products': [],
    'description': props.task.data.description,
    'start_date': props.task.data.start_date,
    'end_date': props.task.data.end_date,
})

const addProduct = () => {
    showAddProductModal()
}

const deleteProduct = (index) => {
    form.products.splice(index, 1)
    selectedItems.value.splice(index, 1)
}
onMounted(() => {
    taskPackage.value = props.project.data.packages.find((item) => {
        return item.id == props.task.data.package.id
    })
    mainPackage.value = props.project.data.packages.find((item) => {
        return item.id == props.task.data.package.parent_id
    })
})
</script>
<template>
    <AuthenticatedLayout>
        <Head title="Task" />

        <div class="sticky z-10 flex items-center gap-2 px-4 py-3 bg-white border-b top-12">
            <h2 class="text-xl font-semibold leading-tight text-gray-800 after:content-['/'] after:ml-2">Project</h2>
            <h3 class="text-lg font-semibold leading-tight text-gray-800 after:content-['/'] after:ml-2">
                {{ project.data.name }}
            </h3>
            <h3 class="text-lg font-semibold leading-tight text-gray-800">
                {{ task.data.name }}
            </h3>
        </div>

        <div class="w-full p-4 md:w-3/5">
            <!-- Card -->
            <form @submit.prevent="form.put(route('project.package.task.update', [ project.data.id, task.data.id ]))">
                <div class="bg-white border">
                    <div class="flex flex-row justify-between px-4 py-2 border-b">
                        <div></div>
                        <div class="flex gap-2 glex-row">
                            <SecondaryButton @click="router.get(route('project.package.show', [ project.data.id, mainPackage.id]))">
                                Kembali
                            </SecondaryButton>
                            <PrimaryButton type="submit">
                                Simpan
                            </PrimaryButton>
                        </div>
                    </div>
                    <div class="py-6">
                        <div class="px-8 mb-4 md:mb-6">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                                Nama Pekerjaan
                            </label>
                            <input type="text" v-model="form.name"
                                class="border-x-0 border-t-0 border-gray-300 hover:border-gray-600 focus:border-gray-600 text-gray-900 text-3xl block w-full p-2.5 focus:ring-0"
                                placeholder="Nama Pekerjaan" required>
                            <template v-if="errors.name">
                                <span class="text-sm text-red-500">{{ errors.name }}</span>
                            </template>
                        </div>
                        <div class="mb-4">
                            <ul class="flex flex-row px-8 border-b">
                                <li class="z-10 flex-nowrap -mr-[1px] cursor-pointer" @click="tabActive = 1">
                                    <div class="p-2 text-sm -mb-[1px] font-light border cursor-pointer whitespace-nowrap " :class="tabActive == 1 ? 'border-t-stone-800 border-b-white bg-white':'bg-gray-50'">
                                        General Information
                                    </div>
                                </li>
                                <li class="flex-nowrap -mr-[1px] cursor-pointer" @click="tabActive = 2">
                                    <div class="p-2 text-sm -mb-[1px] font-light border cursor-pointer whitespace-nowrap" :class="tabActive == 2 ? 'border-t-stone-800 border-b-white bg-white':'bg-gray-50'">
                                        Data Barang & Jasa
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div v-if="tabActive === 1">
                            <div class="grid grid-cols-1 gap-4 px-8 py-4 md:mb-6 md:grid-cols-2">
                                <div class="grid grid-cols-5 align-center">
                                    <div class="col-span-full md:col-span-2 lg:col-span-1">
                                        <label for="user_id" class="text-sm font-medium">Petugas</label>
                                    </div>
                                    <div class="col-span-full md:col-span-3 lg:col-span-4">
                                        <input type="text"
                                            v-model="form.employee"
                                            class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                            placeholder="Nama Petugas"
                                            >
                                        <template v-if="errors.employee">
                                            <span class="text-sm text-red-500">{{ errors.employee }}</span>
                                        </template>
                                    </div>
                                </div>
                                <div>
                                    <input type="hidden" v-model="form.package_id">
                                </div>
                                <div class="grid grid-cols-5 align-center">
                                    <div class="col-span-full md:col-span-2 lg:col-span-1">
                                        <label for="start_date" class="text-sm font-medium">Tanggal Mulai</label>
                                    </div>
                                    <div class="col-span-full md:col-span-3 lg:col-span-4">
                                        <input type="date"
                                            v-model="form.start_date"
                                            class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                            placeholder="Tanggal Mulai"
                                            >
                                        <template v-if="errors.start_date">
                                            <span class="text-sm text-red-500">{{ errors.start_date }}</span>
                                        </template>
                                    </div>
                                </div>
                                <div class="grid grid-cols-5 align-center">
                                    <div class="col-span-full md:col-span-2 lg:col-span-1">
                                        <label for="end_date" class="text-sm font-medium">Tanggal Selesai</label>
                                    </div>
                                    <div class="col-span-full md:col-span-3 lg:col-span-4">
                                        <input type="date"
                                            v-model="form.end_date"
                                            class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                            placeholder="Tanggal Selesai"
                                            >
                                        <template v-if="errors.end_date">
                                            <span class="text-sm text-red-500">{{ errors.end_date }}</span>
                                        </template>
                                    </div>
                                </div>
                                <div class="flex flex-col col-span-2 align-center">
                                    <label for="end_date" class="text-sm font-medium">Deskripsi</label>
                                    <textarea rows="4"
                                        v-model="form.description"
                                        class="block w-full px-0 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                        placeholder="Tulis deskripsi disini"
                                        ></textarea>
                                    <template v-if="errors.description">
                                        <span class="text-sm text-red-500">{{ errors.description }}</span>
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div v-if="tabActive === 2">
                            <div class="relative overflow-x-auto overflow-y-visible">
                                <table class="w-full text-sm text-left text-stone-500">
                                    <thead class="text-xs uppercase text-stone-700 bg-stone-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-2">
                                                Nama Barang / Jasa
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b hover:bg-stone-50" v-for="(product, index) in form.products" :key="index">
                                            <th scope="row"
                                                class="flex gap-2 px-4 py-2 font-medium text-stone-900 whitespace-nowrap">
                                                <button type="button" class="px-2 fill-current text-stone-400 hover:text-stone-800" title="Clear Selected" aria-label="Clear Selected"
                                                    @click="deleteProduct(index)"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"><path d="M6.895455 5l2.842897-2.842898c.348864-.348863.348864-.914488 0-1.263636L9.106534.261648c-.348864-.348864-.914489-.348864-1.263636 0L5 3.104545 2.157102.261648c-.348863-.348864-.914488-.348864-1.263636 0L.261648.893466c-.348864.348864-.348864.914489 0 1.263636L3.104545 5 .261648 7.842898c-.348864.348863-.348864.914488 0 1.263636l.631818.631818c.348864.348864.914773.348864 1.263636 0L5 6.895455l2.842898 2.842897c.348863.348864.914772.348864 1.263636 0l.631818-.631818c.348864-.348864.348864-.914489 0-1.263636L6.895455 5z"></path></svg>
                                                </button>
                                                <span>{{ product.name }}</span>
                                            </th>
                                        </tr>
                                        <tr class="bg-white border-b hover:bg-stone-50">
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-stone-900 whitespace-nowrap">
                                                <a href="#" class="text-xs hover:underline" @click.prevent="addProduct">+ Tambah Barang / Jasa</a>
                                            </th>
                                        </tr>
                                        <tr class="bg-white border-b hover:bg-stone-50">
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-stone-900 whitespace-nowrap"
                                                colspan="2">
                                                &nbsp;
                                            </th>
                                        </tr>
                                        <tr class="bg-white border-b hover:bg-stone-50">
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-stone-900 whitespace-nowrap"
                                                colspan="2">
                                                &nbsp;
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <Modal :show="addProductModal" @close="closeAddProductModal" max-width="2xl" :closeable="false">
            <div class="flex justify-between p-4 border-b">
                <h5 class="text-base font-semibold">
                    Tambah Barang / Jasa
                </h5>
                <button type="button" @click="closeAddProductModal" class="p-[2px] rounded hover:bg-stone-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex flex-col gap-4 px-4 py-6">
                <div class="mb-6">
                    <label for="product" class="text-sm font-medium">Cari Barang</label>
                    <input type="text"
                        v-model="searchProduct"
                        class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                        placeholder="Inputkan Nama Barang / Jasa"
                        >
                </div>
                <div class="overflow-x-auto max-h-60">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th></th>
                                <th scope="col" class="px-6 py-3">
                                    Nama Barang
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Tipe Barang
                                </th>
                            </tr>
                        </thead>
                        <tbody class="">
                            <template v-if="filteredProducts.length">
                                <tr v-for="product in filteredProducts" :key="product.id" class="bg-white border-b hover:bg-gray-50">
                                    <td class="w-4 px-4 py-2">
                                        <div class="flex items-center">
                                            <input v-model="selectedItems" :value="{
                                                'id': product.id,
                                                'name': product.name
                                            }" id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                        </div>
                                    </td>
                                    <th scope="row" class="px-6 py-2 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        {{ product.name }}
                                    </th>
                                    <td class="px-6 text-sm">
                                        {{ product.type.name }}
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
            <div class="p-4 border-t">
                <PrimaryButton type="button" @click="closeAddProductModal">Tambah</PrimaryButton>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<style>

</style>
