<script setup>
import axios from "axios";
import { onMounted, ref } from "vue";

const units = ref([]);
const unit = ref(null);
const search = ref(null);

defineProps({
    product: {
        type: Object,
    },
    units: {
        type: Object,
    },
});

onMounted(() => {
    // get categories from url
    axios.get(route('unit.getData'))
        .then(response => {
            units.value = response.data
            console.log(units.value)
        })
        .catch(error => {
            console.log(error)
        })
})
watch()
</script>

<template>
    <div class="relative">
        <input v-model="search" id="" class="block w-full p-1 px-2 text-sm text-gray-900 border-t-0 border-transparent border-x-0 hover:border-gray-300 focus:border-gray-600 focus:ring-0">
        <div class="absolute bottom-0 text-sm translate-y-full bg-white">
            <ul class="">
                <li class="px-2 py-1 hover:bg-gray-100">Item 1</li>
                <li class="px-2 py-1 hover:bg-gray-100">Item 2</li>
                <li class="px-2 py-1 hover:bg-gray-100">Item 3</li>
            </ul>
        </div>
    </div>
        <!-- <option :value="unit.id" v-for="unit in units.items" :key="unit.id">{{ unit.name }}</option> -->
</template>
