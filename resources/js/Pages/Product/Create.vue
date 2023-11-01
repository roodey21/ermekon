<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import axios from "axios";

const searchResult = ref([]);
const mainUnit = ref(null)
const tabActive = ref(1)

const searching = (search) => {
    axios.get(route('unit.getData', { query: search }))
        .then(response => {
            if(mainUnit.value != null) {
                searchResult.value = response.data.filter(unit => unit.id != mainUnit.value.id)
            } else {
                searchResult.value = response.data
            }
        })
        .catch(error => {
            console.log(error)
        })
    };

const handleSearch = (search, loading) => {
    loading(true)
    searching(search)
    loading(false)
}

const form = useForm({
    name: '',
    type_id: '',
    unit_id: '',
    code: '',
    conversion: [],
    manage_code: false,
    variants: []
})
const addConversion = () => {
    form.conversion.push({
        unit_id: '',
        value: ''
    })
}
const addVariant = () => {
    form.variants.push({
        name: '',
        values: ''
    })
}
const clearRow = (index) => {
    form.conversion.splice(index, 1)
}
const deleteVariant = (index) => {
    form.variants.splice(index, 1)
}
defineProps({
    types: {
        type: Object
    },
    errors: {
        type: Object
    },
    manage_code: {
        type: Boolean,
        default: false
    }
})
// make input code disabled if manage_code is true
watch(() => form.manage_code, (value) => {
    value ? form.manage_code = true : form.manage_code = false
})
watch(mainUnit, (value) => {
    if (value == null) {
        form.conversion = []
        form.unit_id = ''
    } else {
        form.unit_id = value.id
    }
})

defineOptions({
    layout: AuthenticatedLayout
})
</script>

<template>
    <Head title="Tambah Produk Baru" />

    <div class="flex flex-col min-h-screen md:flex-row border-y">
        <div class="md:border-r-2 basis-full md:basis-2/3">
            <div class="p-4 pb-0">
                <div class="flex flex-col justify-between gap-4 mb-4 md:flex-row">
                    <div class="flex flex-col">
                        <div class="flex items-center justify-between gap-3 md:justify-start">
                            <h3 class="text-xl font-semibold capitalize">
                                Produk Baru
                            </h3>
                        </div>
                        <ul class="flex items-center gap-1.5 breadcrumbs">
                            <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                                <Link :href="route('dashboard')" >Dashboard</Link>
                            </li>
                            <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                                Produk
                            </li>
                            <li class="text-sm font-medium text-teal-600 hover:text-teal-900 first:before:hidden before:inline-block before:content-chevron-right before:relative before:top-1 last:text-gray-500">
                                Tambah Produk Baru
                            </li>
                        </ul>
                    </div>
                    <div class="flex flex-row justify-end max-w-md gap-2 grow">

                    </div>
                </div>
            </div>
            <div class="p-4">
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
                                    Nama Produk
                                </label>
                                <input type="text" v-model="form.name"
                                    class="border-x-0 border-t-0 border-gray-300 hover:border-gray-600 focus:border-gray-600 text-gray-900 text-3xl block w-full p-2.5 focus:ring-0"
                                    placeholder="Nama Produk, contoh: batu akik kaki lima" required>
                                <template v-if="errors.name">
                                    <span class="text-sm text-red-500">{{ errors.name }}</span>
                                </template>
                            </div>
                            <!-- <div class="grid grid-cols-1 gap-4 px-8 py-4 mb-4 md:mb-6 md:grid-cols-2">
                                <div class="flex flex-col gap-4">
                                    <div class="grid grid-cols-5 align-center">
                                        <div class="col-span-full md:col-span-2 lg:col-span-1">
                                            <label for="type_id" class="text-sm font-medium">Tipe Produk</label>
                                        </div>
                                        <div class="col-span-full md:col-span-3 lg:col-span-4">
                                            <select v-model="form.type_id"
                                                class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                                >
                                                <option :key="t.id" v-for="t in types" :value="t.id">
                                                    {{ t.name }}
                                                </option>
                                            </select>
                                            <template v-if="errors.type_id">
                                                <span class="text-sm text-red-500">{{ errors.type_id }}</span>
                                            </template>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-5 align-center">
                                        <div class="col-span-full md:col-span-2 lg:col-span-1">
                                            <label for="unit" class="text-sm font-medium">Satuan</label>
                                        </div>
                                        <div class="col-span-full md:col-span-3 lg:col-span-4">
                                            <v-select
                                                v-model="mainUnit"
                                                :options="searchResult"
                                                @search="handleSearch"
                                                class="style-chooser"
                                                label="name"
                                                >
                                            </v-select>
                                            <template v-if="mainUnit">
                                                <div class="grid items-center grid-cols-12 mt-2" v-for="(unit, index) in form.conversion" :key="unit">
                                                    <div class="col-span-1 text-center">
                                                        <button type="button" class="fill-current text-stone-400 hover:text-stone-800" title="Clear Selected" aria-label="Clear Selected"
                                                            @click="clearRow(index)"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"><path d="M6.895455 5l2.842897-2.842898c.348864-.348863.348864-.914488 0-1.263636L9.106534.261648c-.348864-.348864-.914489-.348864-1.263636 0L5 3.104545 2.157102.261648c-.348863-.348864-.914488-.348864-1.263636 0L.261648.893466c-.348864.348864-.348864.914489 0 1.263636L3.104545 5 .261648 7.842898c-.348864.348863-.348864.914488 0 1.263636l.631818.631818c.348864.348864.914773.348864 1.263636 0L5 6.895455l2.842898 2.842897c.348863.348864.914772.348864 1.263636 0l.631818-.631818c.348864-.348864.348864-.914489 0-1.263636L6.895455 5z"></path></svg>
                                                        </button>
                                                    </div>
                                                    <div class="col-span-5">
                                                        <v-select
                                                            v-model="form.conversion[index].unit_id"
                                                            :options="searchResult"
                                                            @search="handleSearch"
                                                            :reduce="unit => unit.id"
                                                            :clearable="false"
                                                            class="style-chooser"
                                                            label="name"
                                                            taggable
                                                            >
                                                        </v-select>
                                                    </div>
                                                    <div class="col-span-1 text-center">
                                                        =
                                                    </div>
                                                    <div class="h-full col-span-3">
                                                        <input type="number"
                                                            v-model="form.conversion[index].value"
                                                            class="block w-full h-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                                        >
                                                    </div>
                                                    <div class="col-span-2 text-sm font-medium text-center">
                                                        {{ mainUnit.name }}
                                                    </div>
                                                </div>
                                            </template>
                                            <template v-if="mainUnit">
                                                <span
                                                    class="text-sm font-medium hover:cursor-pointer hover:underline hover:text-stone-900"
                                                    @click="addConversion"
                                                    >
                                                    +Tambah satuan lain
                                                </span>
                                            </template>
                                            <template v-if="errors.unit_id">
                                                <span class="text-sm text-red-500">{{ errors.unit_id }}</span>
                                            </template>
                                        </div>
                                    </div>

                                </div>
                                <div class="flex flex-col gap-4">
                                    <div class="grid grid-cols-5 align-center">
                                        <div class="col-span-full md:col-span-2 lg:col-span-1">
                                            <div class="relative">
                                                <label class="relative inline-flex items-center cursor-pointer">
                                                    <input type="checkbox" v-model="form.manage_code"
                                                        class="sr-only peer">
                                                    <div
                                                        class="w-8 h-4 bg-stone-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[3px] after:left-[1px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:bg-blue-600">
                                                    </div>
                                                    <span
                                                        class="ml-3 text-sm font-medium text-stone-900">Kode</span>
                                                </label>
                                                <span
                                                    class="absolute bottom-0 hidden p-1 text-xs translate-x-1/2 translate-y-full rounded w-36 right-1/2 text-stone-100 bg-stone-900">aktif
                                                    untuk generate code otomatis</span>
                                            </div>
                                        </div>
                                        <div class="col-span-full md:col-span-3 lg:col-span-4">
                                            <input id="code" v-model="form.code" :disabled="form.manage_code"
                                                class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 disabled:bg-gray-100 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0">
                                            <template v-if="errors.code">
                                                <span class="text-sm text-red-500">{{ errors.code }}</span>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            <div class="mb-4">
                                <ul class="flex flex-row px-8 border-b">
                                    <li class="z-10 flex-nowrap -mr-[1px] cursor-pointer" @click="tabActive = 1">
                                        <div class="p-2 text-sm -mb-[1px] font-light border cursor-pointer whitespace-nowrap " :class="tabActive == 1 ? 'border-t-stone-800 border-b-white bg-white':'bg-gray-50'">
                                            General Information
                                        </div>
                                    </li>
                                    <li class="flex-nowrap -mr-[1px] cursor-pointer" @click="tabActive = 2">
                                        <div class="p-2 text-sm -mb-[1px] font-light border cursor-pointer whitespace-nowrap" :class="tabActive == 2 ? 'border-t-stone-800 border-b-white bg-white':'bg-gray-50'">
                                            Variant
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div v-if="tabActive === 1">
                                <div class="grid grid-cols-1 gap-4 px-8 py-4 mb-4 md:mb-6 md:grid-cols-2">
                                    <div class="flex flex-col gap-4">
                                        <div class="grid grid-cols-5 align-center">
                                            <div class="col-span-full md:col-span-2 lg:col-span-1">
                                                <label for="type_id" class="text-sm font-medium">Tipe Produk</label>
                                            </div>
                                            <div class="col-span-full md:col-span-3 lg:col-span-4">
                                                <select v-model="form.type_id"
                                                    class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                                    >
                                                    <option :key="t.id" v-for="t in types" :value="t.id">
                                                        {{ t.name }}
                                                    </option>
                                                </select>
                                                <template v-if="errors.type_id">
                                                    <span class="text-sm text-red-500">{{ errors.type_id }}</span>
                                                </template>
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-5 align-center">
                                            <div class="col-span-full md:col-span-2 lg:col-span-1">
                                                <label for="unit" class="text-sm font-medium">Satuan</label>
                                            </div>
                                            <div class="col-span-full md:col-span-3 lg:col-span-4">
                                                <v-select
                                                    v-model="mainUnit"
                                                    :options="searchResult"
                                                    @search="handleSearch"
                                                    class="style-chooser"
                                                    label="name"
                                                    >
                                                </v-select>
                                                <template v-if="mainUnit">
                                                    <div class="grid items-center grid-cols-12 mt-2" v-for="(unit, index) in form.conversion" :key="unit">
                                                        <div class="col-span-1 text-center">
                                                            <button type="button" class="fill-current text-stone-400 hover:text-stone-800" title="Clear Selected" aria-label="Clear Selected"
                                                                @click="clearRow(index)"
                                                            >
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"><path d="M6.895455 5l2.842897-2.842898c.348864-.348863.348864-.914488 0-1.263636L9.106534.261648c-.348864-.348864-.914489-.348864-1.263636 0L5 3.104545 2.157102.261648c-.348863-.348864-.914488-.348864-1.263636 0L.261648.893466c-.348864.348864-.348864.914489 0 1.263636L3.104545 5 .261648 7.842898c-.348864.348863-.348864.914488 0 1.263636l.631818.631818c.348864.348864.914773.348864 1.263636 0L5 6.895455l2.842898 2.842897c.348863.348864.914772.348864 1.263636 0l.631818-.631818c.348864-.348864.348864-.914489 0-1.263636L6.895455 5z"></path></svg>
                                                            </button>
                                                        </div>
                                                        <div class="col-span-5">
                                                            <v-select
                                                                v-model="form.conversion[index].unit_id"
                                                                :options="searchResult"
                                                                @search="handleSearch"
                                                                :reduce="unit => unit.id"
                                                                :clearable="false"
                                                                class="style-chooser"
                                                                label="name"
                                                                taggable
                                                                >
                                                            </v-select>
                                                        </div>
                                                        <div class="col-span-1 text-center">
                                                            =
                                                        </div>
                                                        <div class="h-full col-span-3">
                                                            <input type="number"
                                                                v-model="form.conversion[index].value"
                                                                class="block w-full h-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                                                            >
                                                        </div>
                                                        <div class="col-span-2 text-sm font-medium text-center">
                                                            {{ mainUnit.name }}
                                                        </div>
                                                    </div>
                                                </template>
                                                <template v-if="mainUnit">
                                                    <span
                                                        class="text-sm font-medium hover:cursor-pointer hover:underline hover:text-stone-900"
                                                        @click="addConversion"
                                                        >
                                                        +Tambah satuan lain
                                                    </span>
                                                </template>
                                                <template v-if="errors.unit_id">
                                                    <span class="text-sm text-red-500">{{ errors.unit_id }}</span>
                                                </template>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="flex flex-col gap-4">
                                        <div class="grid grid-cols-5 align-center">
                                            <div class="col-span-full md:col-span-2 lg:col-span-1">
                                                <div class="relative">
                                                    <label class="relative inline-flex items-center cursor-pointer">
                                                        <input type="checkbox" v-model="form.manage_code"
                                                            class="sr-only peer">
                                                        <div
                                                            class="w-8 h-4 bg-stone-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[3px] after:left-[1px] after:bg-white after:border-stone-300 after:border after:rounded-full after:h-3.5 after:w-3.5 after:transition-all peer-checked:bg-blue-600">
                                                        </div>
                                                        <span
                                                            class="ml-3 text-sm font-medium text-stone-900">Kode</span>
                                                    </label>
                                                    <span
                                                        class="absolute bottom-0 hidden p-1 text-xs translate-x-1/2 translate-y-full rounded w-36 right-1/2 text-stone-100 bg-stone-900">aktif
                                                        untuk generate code otomatis</span>
                                                </div>
                                            </div>
                                            <div class="col-span-full md:col-span-3 lg:col-span-4">
                                                <input id="code" v-model="form.code" :disabled="form.manage_code"
                                                    class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-gray-300 disabled:bg-gray-100 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0">
                                                <template v-if="errors.code">
                                                    <span class="text-sm text-red-500">{{ errors.code }}</span>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="tabActive === 2">
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
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="bg-white basis-full md:basis-1/3">
            <div class="sticky top-0 px-4 py-3 bg-white basis-2/3">
                <div class="flex flex-row items-center justify-between">
                    <PrimaryButton>
                        Kirim Pesan
                    </PrimaryButton>
                </div>
            </div>
        </div>
    </div>

</template>

<style>
.v-select {
    width: 100% !important;
}
</style>
