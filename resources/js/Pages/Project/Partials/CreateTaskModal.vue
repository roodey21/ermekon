<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { XMarkIcon } from '@heroicons/vue/24/outline';
import { router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
    products: {
        type: Object,
        required: true,
    }
})

const showModal = ref(false)
const projectPackage = ref(null)
const subPackage = ref(null)

const form = useForm({
    name: '',
    description: '',
    products: []
})

const openModal = (packageId, subpackageId) => {
    projectPackage.value = props.project.data.packages.find((p) => p.id === packageId)
    subPackage.value = projectPackage.value.subpackages.find((s) => s.id === subpackageId)
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
}

const handleSubmit = () => {
    console.log('submitted')
}

const searchProduct = (search) => {
    router.reload({
        only: ['products'],
        data: {
            search
        }
    })
}

const addTaskItem = () => {
    form.products.push({
        name: '',
        volume: '',
        transaction_type: '',
        price: ''
    })
}

const deleteTaskItem = (index) => {
    form.products.splice(index, 1)
}

defineExpose({
    openModal,
    closeModal
})
</script>

<template>
    <Modal :show="showModal" @close="closeModal" max-width="6xl" :closeable="false">
        <form @submit.prevent="handleSubmit">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-100 border-b">
                <h5 class="text-sm font-medium">
                    {{ project.data.name }} / {{ projectPackage.name }} / {{ subPackage.name }}
                </h5>
                <button type="button" @click="closeModal" class="p-[2px] rounded bg-white border">
                    <XMarkIcon class="w-3.5 h-3.5" />
                </button>
            </div>
            <div class="flex flex-row divide-x">
                <div class="px-4 py-6 basis-3/5 h-[70vh] overflow-y-scroll scroll-smooth">
                    <div class="mb-2">
                        <input type="text"
                            class="w-full p-2 -ml-2 text-2xl font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                            v-model="form.name" placeholder="Nama Item Pekerjaan">
                    </div>
                    <div class="mb-2">
                        <textarea rows="8"
                            class="w-full p-2 -ml-2 text-sm font-light text-gray-900 border border-gray-200 border-opacity-0 rounded placeholder:text-gray-600 focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                            placeholder="deskripsi atau catatan lainnya ditulis disini"
                            v-model="form.description"></textarea>
                    </div>
                    <div class="items-form">
                        <div class="flex items-center gap-3 py-2 mb-2">
                            <h6 class="text-base font-medium text-gray-600">Barang & Jasa</h6>
                            <button @click="addTaskItem"
                                class="py-0.5 px-2 rounded border border-teal-700 text-teal-700 bg-white text-xs">
                                Add
                            </button>
                        </div>
                        <table class="w-full">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th></th>
                                    <th class="text-sm font-medium text-center">Nama</th>
                                    <th class="text-sm font-medium text-center">Volume</th>
                                    <th class="text-sm font-medium text-center">Jenis Transaksi</th>
                                    <th class="text-sm font-medium text-center">Harga Satuan</th>
                                </tr>
                            </thead>
                            <tbody class="space-y-2">
                                <tr v-for="(item, index) in form.products" :key="item.id">
                                    <td>
                                        <span @click="deleteTaskItem(index)">
                                            x
                                        </span>
                                    </td>
                                    <td class="text-sm font-light">
                                        <span class="line-clamp-1">
                                            Pipa PVC AW dia. 4" (Pipa Tegak)
                                        </span>
                                    </td>
                                    <td class="text-sm font-light text-center" width="150px">100 m</td>
                                    <td class="text-sm font-light text-center" width="150px">Pembelian</td>
                                    <td class="text-sm font-light text-center" width="150px">50,000</td>
                                </tr>
                                <tr>
                                    <td class="text-sm font-light">
                                        <v-select v-model="test" :options="products.data" :reduce="product => product.id"
                                            :clearable="false" label="name" @search="searchProduct" class="searchProduct">
                                        </v-select>
                                        <!-- <div class="relative">
                                            <input class="w-full p-0 text-sm border-0 rounded focus:border-0 focus:ring-0 placeholder:text-gray-400" placeholder="Cari barang" @input="handleSearchProduct">
                                            <template v-if="isSearching">
                                                <div class="absolute bottom-0 z-50 w-full translate-y-full bg-white border search-wrapper">
                                                    <ul class="py-2">
                                                        <li class="p-2" v-for="product in products.data" :key="product.id">{{ product.name }}</li>
                                                    </ul>
                                                </div>
                                            </template>
                                        </div> -->
                                    </td>
                                    <td class="text-sm font-light text-center">100 m</td>
                                    <td class="text-sm font-light text-center">Pembelian</td>
                                    <td class="text-sm font-light text-center">50,000</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="4">&nbsp;</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="px-4 py-6 w-72 basis-2/5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-light">you membuat item pekerjaan ini.</span>
                        <span class="text-[11px] font-light">Yesterday at 08.00 am</span>
                    </div>
                </div>
            </div>
            <div class="p-4 text-right border-t">
                <PrimaryButton type="submit" :disabled="form.processing">Simpan</PrimaryButton>
            </div>
        </form>
    </Modal>
</template>

<style></style>
