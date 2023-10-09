<script setup>
import { PlusIcon } from '@heroicons/vue/24/outline'

const emit = defineEmits(['showAddItem'])

const showAddItem = () => {
    emit('showAddItem')
}
defineProps({
    task: {
        type: Object,
        default: () => []
    }
})
</script>
<template>
    <div class="flex pl-16 pr-8 border-b border-gray-200 group hover:bg-gray-100 hover:cursor-pointer table-header">
        <div class="flex py-3 grow">
            <div class="text-sm font-medium">
                {{ task.name }}
            </div>
        </div>
        <div class="flex items-center">
            <div class="w-40 py-2">
                <div class="text-xs font-light text-center">
                    Pembelian Site
                </div>
            </div>
            <div class="w-40 py-2">
                <div class="text-xs font-light text-center">
                    5
                </div>
            </div>
            <div class="w-40 py-2">
                <div class="text-xs font-light text-center">
                    m
                </div>
            </div>
        </div>
    </div>
    <div class="flex pl-16 pr-8 border-b border-gray-200 table-header">
        <div class="py-2.5 opacity-60 grow-0 hover:cursor-pointer" @click="showAddItem">
            <div class="flex items-center gap-2 px-2 py-1 text-gray-800 transition-all bg-gray-200 bg-opacity-0 rounded hover:bg-opacity-100">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.99984 4.66675V7.00008M6.99984 7.00008V9.33341M6.99984 7.00008H9.33317M6.99984 7.00008H4.6665" stroke="black" stroke-opacity="0.5" stroke-width="1.16667" stroke-linecap="round"/>
                    <path d="M6.99984 12.8334C10.2215 12.8334 12.8332 10.2217 12.8332 7.00008C12.8332 3.77842 10.2215 1.16675 6.99984 1.16675C3.77818 1.16675 1.1665 3.77842 1.1665 7.00008C1.1665 10.2217 3.77818 12.8334 6.99984 12.8334Z" stroke="black" stroke-opacity="0.5" stroke-width="1.16667"/>
                </svg>
                <div class="text-xs font-medium h-min">
                    Tambah Item Pekerjaan
                </div>
            </div>
        </div>
    </div>
</template>
