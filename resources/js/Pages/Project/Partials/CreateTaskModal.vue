<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ArrowRightIcon, EllipsisHorizontalIcon, TrashIcon, UserPlusIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { router, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

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

const filteredProduct = computed(() => {
    return props.products.data.filter((product) => {
        return form.products.find((p) => p.id != product.id)
    })
})
const form = useForm({
    name: '',
    description: '',
    package_id: null,
    products: []
})

const openModal = (packageId, subpackageId) => {
    projectPackage.value = props.project.data.packages.find((p) => p.id === packageId)
    subPackage.value = projectPackage.value.subpackages.find((s) => s.id === subpackageId)
    showModal.value = true
    form.package_id = subPackage.value.id
}

const closeModal = () => {
    showModal.value = false
    form.reset()
}

const handleSubmit = () => {
    form.post(route('project.package.task.store', props.project.data.id), {
        onSuccess: () => {
            closeModal()
            form.reset()
        }
    })
}

// const searchProduct = (search) => {
//     console.log(filteredProduct.value)
//     router.reload({
//         only: ['products'],
//         data: {
//             search
//         }
//     })
// }

const addTaskItem = () => {
    form.products.push({
        id: '',
        name: '',
        volume: '',
        transaction_type: '',
        price: ''
    })
}

const deleteTaskItem = (index) => {
    form.products.splice(index, 1)
}

const showProductModal = ref(false)

const openProductModal = () => {
    showProductModal.value = true
}

const closeProductModal = () => {
    showProductModal.value = false
}

const searchProduct = (search) => {
    router.reload({
        only: ['products'],
        data: {
            search : search.target.value
        }
    })
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
                <div class="basis-3/5 ">
                    <div class="flex flex-row justify-between p-4 border-b">
                        <div class="flex flex-row-reverse">
                            <div
                                class="flex justify-center w-10 h-10 -ml-4 text-white border-2 border-teal-600 border-dashed rounded-full opacity-25 hover:opacity-100 hover:cursor-pointer">
                                <UserPlusIcon class="self-center w-6 h-6 text-teal-600" />
                            </div>
                            <div class="z-10 flex w-10 h-10 -ml-4 text-white bg-teal-600 border rounded-full">
                                <span class="self-center w-full text-center text-[12px]">FA</span>
                            </div>
                            <div class="z-10 flex w-10 h-10 text-white bg-teal-600 border rounded-full">
                                <span class="self-center w-full text-center text-[12px]">FA</span>
                            </div>
                        </div>
                        <div>
                            <Dropdown align="left">
                                <template #trigger>
                                    <div class="group hover:cursor-pointer">
                                        <EllipsisHorizontalIcon
                                            class="w-6 h-6 transition-all group-hover:text-teal-700 group-hover:scale-125" />
                                    </div>
                                </template>

                                <template #content>
                                    <ul class="p-1.5 text-black">
                                        <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded">
                                            <div class="flex items-center gap-2 text-xs text-red-700">
                                                <TrashIcon class="w-3 h-3" />
                                                <span>Hapus Paket Pekerjaan</span>
                                            </div>
                                        </li>
                                    </ul>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                    <div class="px-4 py-6 h-[70vh] overflow-y-scroll scroll-smooth">
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
                                <button type="button" @click="openProductModal"
                                    class="py-0.5 px-2 rounded border border-teal-700 text-teal-700 bg-white text-xs">
                                    Add
                                </button>
                            </div>
                            <table class="w-full">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="w-2"></th>
                                        <th class="text-sm font-medium text-center">Nama</th>
                                        <th class="text-sm font-medium text-center">Volume</th>
                                        <th class="text-sm font-medium text-center">Jenis Transaksi</th>
                                        <th class="text-sm font-medium text-center">Harga Satuan</th>
                                    </tr>
                                </thead>
                                <tbody class="space-y-2">
                                    <tr v-for="(item, index) in form.products" :key="item.id" class="group">
                                        <td>
                                            <XMarkIcon
                                                class="w-3 h-3 opacity-0 hover:cursor-pointer group-hover:opacity-100"
                                                @click="deleteTaskItem(index)" />
                                        </td>
                                        <td class="text-xs font-light">
                                            <v-select v-model="form.products[index].id" :options="filteredProduct"
                                                :reduce="product => product.id" :clearable="false" label="name"
                                                @search="searchProduct" class="searchProduct">
                                            </v-select>
                                            <!-- <span class="line-clamp-1">
                                                Pipa PVC AW dia. 4" (Pipa Tegak)
                                            </span> -->
                                        </td>
                                        <td class="text-xs font-light text-center" width="150px">100 m</td>
                                        <td class="text-xs font-light text-center" width="150px">Pembelian</td>
                                        <td class="text-xs font-light text-center" width="150px">50,000</td>
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
    <Modal :show="showProductModal" @close="closeProductModal" max-width="4xl" :closeable="true">
        <div class="flex items-center justify-between px-4 py-3 bg-gray-100 border-b">
            <h5 class="text-sm font-medium">
                {{ project.data.name }} / {{ projectPackage.name }} / {{ subPackage.name }}
            </h5>
            <button type="button" @click="closeProductModal" class="p-[2px] rounded bg-white border">
                <XMarkIcon class="w-3.5 h-3.5" />
            </button>
        </div>
        <div class="flex flex-row divide-x">
            <div class="px-4 py-6 basis-3/5 grow">
                <div class="mb-4">
                    <input type="text"
                        class="w-full p-2 text-base font-light text-gray-900 border border-gray-200 rounded focus:ring-0 focus:border-gray-400"
                        placeholder="Cari Produk" @input="searchProduct">
                </div>
                <!-- <div class="mb-2">
                    <span class="text-sm text-gray-800">Hasil pencarian</span>
                </div> -->
                <div class="relative overflow-x-auto border">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-3 py-3">
                                    Kode
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Nama Produk
                                </th>
                                <th scope="col" class="px-3 py-3">
                                    Jenis
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="relative text-xs bg-white border-b dark:bg-gray-800 group dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 hover:cursor-pointer" v-for="product in products.data" :key="product.id">
                                <th scope="row"
                                    class="px-3 py-2.5 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ product.code }}
                                </th>
                                <td class="px-3 py-2">
                                    {{ product.name }}
                                </td>
                                <td class="px-3 py-2">
                                    {{ product.type.name }}
                                </td>
                                <div class="absolute invisible -translate-y-1/2 right-1 group-hover:visible top-1/2">
                                    <ArrowRightIcon class="w-4 h-4 text-gray-500" />
                                </div>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="px-4 py-6 basis-2/5">
                <div class="grid grid-cols-2 gap-3">
                    <div class="col-span-2">
                        <label for="" class="text-xs">Nama Produk</label>
                        <div>
                            <input type="text"
                                class="w-full p-2 text-sm font-light text-gray-900 border border-gray-200 rounded focus:ring-0 focus:border-gray-400">
                        </div>
                    </div>
                    <div>
                        <label for="" class="text-xs">Satuan</label>
                        <select type="text"
                                class="w-full p-2 text-sm font-light text-gray-900 border border-gray-200 rounded focus:ring-0 focus:border-gray-400 placeholder:text-sm">
                            <option value="">Pilih Satuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="" class="text-xs">Volume</label>
                        <input type="text"
                                class="w-full p-2 text-sm font-light text-gray-900 border border-gray-200 rounded focus:ring-0 focus:border-gray-400">
                    </div>
                    <div>
                        <label for="" class="text-xs">Jenis Transaksi</label>
                        <input type="text"
                                class="w-full p-2 text-sm font-light text-gray-900 border border-gray-200 rounded focus:ring-0 focus:border-gray-400">
                    </div>
                    <div>
                        <label for="" class="text-xs">Harga Satuan</label>
                        <input type="text"
                                class="w-full p-2 text-sm font-light text-gray-900 border border-gray-200 rounded focus:ring-0 focus:border-gray-400">
                    </div>
                </div>
            </div>
        </div>
        <div class="p-4 text-right border-t">
                <PrimaryButton type="submit" :disabled="form.processing">Simpan</PrimaryButton>
            </div>
    </Modal>
</template>

<style></style>
