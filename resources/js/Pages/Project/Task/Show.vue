<script setup>
import { Link, router, Head, useForm } from '@inertiajs/vue3'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import Modal from '@/Components/Modal.vue'

import { onMounted, ref } from 'vue';

const tabActive = ref(1)

const { project, task } = defineProps({
    errors: Object,
    project: Object,
    task: Object
})

const taskPackage = ref([])

const form = useForm({
    'name': task.data.name
})

onMounted(() => {
    taskPackage.value = project.data.packages.filter((item) => {
        return item.id == task.data.package_id
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
            <form @submit.prevent="form.post(route('product.store'))">
                <div class="bg-white border">
                    <div class="flex flex-row justify-between px-4 py-2 border-b">
                        <div></div>
                        <div class="flex gap-2 glex-row">
                            <SecondaryButton @click="router.get(route('product.index'))">
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
                                            class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                            placeholder="Nama Petugas"
                                            >
                                        <template v-if="errors.user_id">
                                            <span class="text-sm text-red-500">{{ errors.user_id }}</span>
                                        </template>
                                    </div>
                                </div>
                                <div></div>
                                <div class="grid grid-cols-5 align-center">
                                    <div class="col-span-full md:col-span-2 lg:col-span-1">
                                        <label for="start_date" class="text-sm font-medium">Tanggal Mulai</label>
                                    </div>
                                    <div class="col-span-full md:col-span-3 lg:col-span-4">
                                        <input type="text"
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
                                        <input type="text"
                                            class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                            placeholder="Tanggal Selesai"
                                            >
                                        <template v-if="errors.end_date">
                                            <span class="text-sm text-red-500">{{ errors.end_date }}</span>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div v-if="tabActive === 2">
                            <div class="relative overflow-x-auto overflow-y-visible">
                                <table class="w-full text-sm text-left text-stone-500">
                                    <thead class="text-xs uppercase text-stone-700 bg-stone-50">
                                        <tr>
                                            <th scope="col" class="px-4 py-2 text-center">
                                                Nama Variant
                                            </th>
                                            <th scope="col" class="w-2/3 px-4 py-2 ">
                                                Value
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="bg-white border-b hover:bg-stone-50" v-for="(variant, index) in form.variants" :key="index">
                                            <th scope="row"
                                                class="flex gap-2 px-4 py-2 font-medium text-stone-900 whitespace-nowrap">
                                                <button type="button" class="px-2 fill-current text-stone-400 hover:text-stone-800" title="Clear Selected" aria-label="Clear Selected"
                                                    @click="deleteVariant(index)"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"><path d="M6.895455 5l2.842897-2.842898c.348864-.348863.348864-.914488 0-1.263636L9.106534.261648c-.348864-.348864-.914489-.348864-1.263636 0L5 3.104545 2.157102.261648c-.348863-.348864-.914488-.348864-1.263636 0L.261648.893466c-.348864.348864-.348864.914489 0 1.263636L3.104545 5 .261648 7.842898c-.348864.348863-.348864.914488 0 1.263636l.631818.631818c.348864.348864.914773.348864 1.263636 0L5 6.895455l2.842898 2.842897c.348863.348864.914772.348864 1.263636 0l.631818-.631818c.348864-.348864.348864-.914489 0-1.263636L6.895455 5z"></path></svg>
                                                </button>
                                                <v-select
                                                    v-model="form.variants[index].name"
                                                    class="style-chooser"
                                                    placeholder="ex: Warna, Ukuran"
                                                    taggable
                                                >

                                                </v-select>
                                            </th>
                                            <td class="px-4 py-2">
                                                <v-select
                                                    v-model="form.variants[index].values"
                                                    class="style-chooser"
                                                    taggable
                                                    multiple
                                                    >
                                                </v-select>
                                            </td>
                                        </tr>
                                        <tr class="bg-white border-b hover:bg-stone-50">
                                            <th scope="row"
                                                class="px-4 py-3 font-medium text-stone-900 whitespace-nowrap">
                                                <a href="#" class="text-xs hover:underline" @click.prevent="addVariant">+ Tambah Variant</a>
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
                        </div> -->
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<style>

</style>
