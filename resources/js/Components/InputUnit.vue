<script setup>
import axios from "axios";
import { ref } from "vue";

const selectedOption = ref(null);
const searchResult = ref([]);

const searching = (search) => {
    axios.get(route('unit.getData', { query: search }))
        .then(response => {
            searchResult.value = response.data
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
</script>

<template>
    <v-select
        v-model="selectedOption"
        :options="searchResult"
        @search="handleSearch"
        class="style-chooser"
        label="name"
        >
        <template #list-footer="{ search }">
            <li class="text-center">
                <a href="">
                    Buat "{{ search }}"
                </a>
            </li>
        </template>
    </v-select>
</template>

<style>
.style-chooser .vs__dropdown-toggle {
    @apply text-sm text-gray-900 border-t-0 border-transparent border-x-0 hover:border-gray-300 focus:border-gray-600 focus:ring-0
}
.style-chooser .vs__actions{
    @apply pr-3
}
.style-chooser .vs__open-indicator {
    @apply scale-75
}
</style>
