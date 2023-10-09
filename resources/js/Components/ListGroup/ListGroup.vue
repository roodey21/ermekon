<script setup>
import { ref, nextTick, onMounted, onUpdated } from 'vue'
import { onClickOutside } from '@vueuse/core'
import { useForm } from '@inertiajs/vue3'
import Modal from '@/Components/Modal.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Tiptap from '@/Components/Tiptap.vue'

const props = defineProps({
    projectPackage: {
        type: Object,
        required: true
    }
})

const addNewSubpackage = () => {

}

const showEditPackageModal = ref(false)
const showSubPackageForm = ref(false)
const showList = ref(true)
const input = ref(null)

const handleShowSubPackageForm = async () => {
    showSubPackageForm.value = true
    await nextTick()
    input.value.focus()
}
const formPackage = useForm({
    name: props.projectPackage.name,
    description: props.projectPackage.description
})

const handleSubmitPackage = () => {
    formPackage.put(route('project.package.update', [props.projectPackage.project_id, props.projectPackage.id]), {
        onSuccess: () => {
            showEditPackageModal.value = false
            formPackage.reset()
        }
    })
}
onClickOutside(input, (event) => showSubPackageForm.value = false)
// onUpdated(() => {
//     formPackage.name = props.projectPackage.name
//     formPackage.description = props.projectPackage.description
// })
</script>
<template>
    <div class="w-full bg-white border rounded-lg shadow">
        <div class="flex flex-col p-3 header">
            <div class="flex gap-2 mb-3">
                <span class="inline-block transition-all -rotate-90 hover:cursor-pointer" @click="showList = !showList" :class="showList ? 'rotate-0':''">
                    <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 7.5L9 14.1667L15 7.5" stroke="black" stroke-width="1.16667" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </span>
                <div class="flex items-center gap-3">
                    <h5 class="text-base font-medium select-none text-gray-950">
                        {{ projectPackage.name }}
                    </h5>
                    <span class="bg-amber-500 text-white px-2 py-0.5 text-[10px] uppercase rounded-full" v-if="projectPackage.subpackages.length">
                        {{ projectPackage.subpackages.length }} Sub Pekerjaan
                    </span>
                </div>
            </div>
            <template v-if="projectPackage.description">
                <div class="text-sm text-gray-800 pl-7 font-extralight" @click="showEditPackageModal=true" v-html="projectPackage.description">
                </div>
            </template>
            <template v-else>
                <form @submit.prevent="handleSubmitPackage" class="w-full -ml-4 pl-7">
                    <textarea
                        class="w-full px-4 pt-1 text-sm border-gray-400 border-opacity-0 rounded peer hover:border-opacity-100 focus:ring-0 focus:border-gray-400"
                        placeholder="Tulis deskripsi disini"
                        v-model="formPackage.description"
                        @focus="showEditPackageModal=true"
                        ></textarea>
                </form>
            </template>
        </div>
        <div class="body" v-show="showList">
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

            <slot />

            <div class="flex flex-col">
                <div class="flex px-8 border-b border-gray-200">
                    <div class="py-2.5 grow" v-show="showSubPackageForm">
                        <div class="flex gap-4 justify-between items-center pl-6 py-2.5 border border-emerald-600">
                            <input ref="input" type="text" class="w-full p-0 text-sm font-light border-0 grow focus:ring-0" @keyup.esc="showSubPackageForm=false">
                            <div class="flex items-center gap-4 pr-2">
                                <p class="text-[11px] whitespace-nowrap text-gray-500">Press Enter to save</p>
                                <button type="button" class="flex items-center text-emerald-800 py-0.5 px-2 border hover:bg-emerald-800 hover:text-white border-emerald-700 gap-1 text-xs font-medium uppercase bg-white">
                                    Save
                                </button>
                                <button type="reset" class="py-0.5 px-2 text-xs" @click="showSubPackageForm=false">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.6668 11.6668L2.3335 2.3335M11.6668 2.3335L2.3335 11.6668" stroke="#9CA3AF" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="py-2.5 opacity-60 grow-0 hover:cursor-pointer" v-show="!showSubPackageForm">
                        <div class="flex items-center gap-2 px-2 py-1 text-gray-800 transition-all bg-gray-200 bg-opacity-0 rounded hover:bg-opacity-100" @click="handleShowSubPackageForm">
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.99984 4.66675V7.00008M6.99984 7.00008V9.33341M6.99984 7.00008H9.33317M6.99984 7.00008H4.6665" stroke="black" stroke-opacity="0.5" stroke-width="1.16667" stroke-linecap="round"/>
                                <path d="M6.99984 12.8334C10.2215 12.8334 12.8332 10.2217 12.8332 7.00008C12.8332 3.77842 10.2215 1.16675 6.99984 1.16675C3.77818 1.16675 1.1665 3.77842 1.1665 7.00008C1.1665 10.2217 3.77818 12.8334 6.99984 12.8334Z" stroke="black" stroke-opacity="0.5" stroke-width="1.16667"/>
                            </svg>
                            <div class="text-xs font-medium h-min">
                                Tambah Sub Pekerjaan Baru
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Modal :show="showEditPackageModal" @close="showEditPackageModal=false" max-width="2xl" :closeable="false">
        <form @submit.prevent="handleSubmitPackage">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-100 border-b">
                <h5 class="text-sm font-medium">
                    Edit Paket Pekerjaan
                </h5>
                <button type="button" @click="showEditPackageModal=false" class="p-[2px] rounded bg-white border">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="px-4 py-6">
                <div class="mb-2">
                    <input type="text"
                        class="w-full p-2 -ml-2 text-2xl font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                        v-model="formPackage.name"
                        placeholder="Nama Paket Pekerjaan">
                </div>
                <div class="mb-2">
                    <Tiptap
                        v-model="formPackage.description"
                    />
                    <!-- <textarea
                        rows="8"
                        class="w-full p-2 -ml-2 text-sm font-light text-gray-900 border border-gray-200 border-opacity-0 rounded placeholder:text-gray-600 focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                        placeholder="deskripsi atau catatan lainnya ditulis disini"
                        v-model="formPackage.description"></textarea> -->
                </div>
            </div>
            <div class="p-4 border-t">
                <PrimaryButton type="submit" :disabled="formPackage.processing">Simpan</PrimaryButton>
            </div>
        </form>
    </Modal>
</template>
