<script setup>
import { ref } from 'vue'
import GroupList from '@/Components/Table/GroupList.vue'

defineProps({

})

</script>
<template>
    <div class="w-full bg-white border rounded-lg shadow">
        <div class="flex flex-col p-3 header">
            <div class="flex gap-2 mb-3">
                <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3 7.5L9 14.1667L15 7.5" stroke="black" stroke-width="1.16667" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <div class="flex items-center gap-3">
                    <h5 class="text-base font-normal text-black">
                        Plumbing
                    </h5>
                    <span class="bg-amber-500 text-white px-2 py-0.5 text-[10px] uppercase rounded-full">
                        3 Sub Pekerjaan
                    </span>
                </div>
            </div>
            <p class="text-sm pl-7 font-extralight">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta expedita, autem vitae eum, dolorum pariatur
                iste perferendis ullam tempore vero exercitationem, labore rerum est neque porro. Dicta optio numquam ex!
            </p>
        </div>
        <div class="body">
            <div class="flex px-8 border-b border-gray-300 table-header">
                <div class="py-2 grow">
                    <div class="text-sm font-medium">
                        Sub Paket Pekerjaan
                    </div>
                </div>
                <div class="flex">
                    <div class="w-40 py-2">
                        <div class="text-xs font-medium text-center">
                            Jenis Transaksi
                        </div>
                    </div>
                    <div class="w-40 py-2">
                        <div class="text-xs font-medium text-center">
                            Volume
                        </div>
                    </div>
                    <div class="w-40 py-2">
                        <div class="text-xs font-medium text-center">
                            Satuan
                        </div>
                    </div>
                </div>
            </div>
            <GroupList name="Instalasi Air Bersih" />
            <GroupList name="Instalasi Air Kotor & Pembuangan" />
            <div class="flex flex-col">
                <div class="flex px-8 border-b border-gray-200 hover:bg-gray-100 hover:cursor-pointer">
                    <div class="py-3.5 grow">
                        <div class="flex items-center gap-2">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.99984 4.66675V7.00008M6.99984 7.00008V9.33341M6.99984 7.00008H9.33317M6.99984 7.00008H4.6665" stroke="black" stroke-opacity="0.5" stroke-width="1.16667" stroke-linecap="round"/>
                                <path d="M6.99984 12.8334C10.2215 12.8334 12.8332 10.2217 12.8332 7.00008C12.8332 3.77842 10.2215 1.16675 6.99984 1.16675C3.77818 1.16675 1.1665 3.77842 1.1665 7.00008C1.1665 10.2217 3.77818 12.8334 6.99984 12.8334Z" stroke="black" stroke-opacity="0.5" stroke-width="1.16667"/>
                            </svg>
                            <div class="text-sm font-medium h-min hover:text-emerald-700">
                                Tambah Sub Pekerjaan Baru
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
