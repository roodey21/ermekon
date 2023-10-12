<script setup>
    import { ref } from 'vue'

    const dropdown = ref(false)

    const toggleDropdown = () => {
        dropdown.value = !dropdown.value
    }

    const closeDropdown = () => {
        dropdown.value = false
    }

    const open = ref(false)
</script>

<template>
    <div class="relative">
        <div class="flex items-center h-full gap-2 px-4 text-gray-500 hover:cursor-pointer hover:bg-gray-200" @click="open=!open" :class="{ 'bg-gray-200' : open}">
            <div class="bg-gray-900 rounded-full h-9 w-9"></div>
            <div>
                <div class="text-base">Ermekon Daya Mephindo</div>
                <div class="text-sm">Fahrudin Abadi</div>
            </div>
        </div>
        <div v-show="open" class="fixed inset-0 z-40" @click="open = false"></div>
        <div v-show="open" class="absolute z-50 translate-y-full bg-white border rounded shadow w-52 right-2 bottom-1">
            <ul class="py-1 text-sm text-black">
                <li class="px-3 py-2 hover:bg-gray-100 hover:cursor-pointer">Profile</li>
                <li class="px-3 py-2 hover:bg-gray-100 hover:cursor-pointer">Logout</li>
            </ul>
        </div>
    </div>
</template>
