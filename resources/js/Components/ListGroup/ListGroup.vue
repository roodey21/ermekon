<script setup>
import { ref, nextTick, onMounted, onUpdated, watch } from 'vue'
import { onClickOutside } from '@vueuse/core'
import { useForm } from '@inertiajs/vue3'
import { ChevronDownIcon, PlusCircleIcon, XMarkIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
    projectPackage: {
        type: Object,
        required: true
    }
})

const createSubPackageForm = useForm({
    name: '',
    parent_id: props.projectPackage.id
})
const updateFormName = (event) => {
    createSubPackageForm.name = event.target.value
}
const emit = defineEmits(['updatePackage'])
const editPackage = () => {
    emit('updatePackage', props.projectPackage.id)
}
const showSubPackageForm = ref(false)
const showList = ref(true)
const input = ref(null)

const handleShowSubPackageForm = () => {
    showSubPackageForm.value = true
    nextTick(() => input.value.focus())
}

const handleSubmitCreateSubPackage = () => {
    if (!createSubPackageForm.name) return
    createSubPackageForm.post(route('project.package.store-subpackage', props.projectPackage.project_id), {
        onSuccess: () => {
            input.value.value = ''
            createSubPackageForm.reset()
        }
    })
}

onClickOutside(input, (event) => showSubPackageForm.value = false)

</script>
<template>
    <div class="w-full min-w-[500px] bg-white border rounded-lg shadow">
        <div class="flex flex-col p-3 header">
            <div class="flex gap-1.5 mb-3">
                <ChevronDownIcon class="inline-block w-5 h-5 text-gray-500 transition-all -rotate-90 hover:cursor-pointer" :class="{'rotate-0':showList}" @click="showList = !showList"/>
                <div class="flex items-center gap-3">
                    <h5 class="text-base font-medium select-none text-gray-950 hover:cursor-pointer hover:text-emerald-900"  @click="editPackage">
                        {{ projectPackage.name }}
                    </h5>
                    <span class="bg-teal-700 text-white px-2 py-0.5 text-[10px] uppercase rounded-full" v-if="projectPackage.subpackages.length">
                        {{ projectPackage.subpackages.length }} Sub Pekerjaan
                    </span>
                </div>
            </div>
            <template v-if="projectPackage.description">
                <div class="text-sm text-gray-600 pl-7 font-extralight" @click="editPackage" v-html="projectPackage.description"></div>
            </template>
            <template v-else>
                <div class="w-full -ml-4 pl-7">
                    <textarea
                        class="w-full px-4 pt-1 text-sm border-gray-400 border-opacity-0 rounded peer hover:border-opacity-100 focus:ring-0 focus:border-gray-400 placeholder:text-gray-400"
                        placeholder="Tambahkan deskripsi"
                        @focus="editPackage"
                        ></textarea>
                </div>
            </template>
        </div>
        <div class="body" v-show="showList">
            <div class="flex px-8 border-b border-gray-300 table-header">
                <div class="px-2 py-1.5 text-gray-700 bg-gray-200 rounded-t-lg ">
                    <div class="text-xs font-medium uppercase">
                        Sub Paket Pekerjaan
                    </div>
                </div>
            </div>

            <slot />

            <div class="flex flex-col">
                <div class="flex px-8 border-b border-gray-200">
                    <div class="py-2.5 grow" v-show="showSubPackageForm">
                        <form @submit.prevent="handleSubmitCreateSubPackage" class="flex gap-4 justify-between items-center pl-6 py-2.5 border border-emerald-600">
                            <input ref="input" @input="updateFormName" type="text" class="w-full p-0 text-sm font-light border-0 grow focus:ring-0" @keyup.esc="showSubPackageForm=false">
                            <div class="flex items-center gap-2 pr-2 md:gap-4">
                                <p class="text-[11px] whitespace-nowrap text-gray-500">Press Enter to save</p>
                                <button type="button" class="flex items-center text-emerald-800 py-0.5 px-2 border hover:bg-emerald-800 hover:text-white border-emerald-700 gap-1 text-xs font-medium uppercase bg-white">
                                    Save
                                </button>
                                <button type="reset" class="py-0.5 px-1 md:px-2 text-xs" @click="showSubPackageForm=false">
                                    <XMarkIcon class="w-4 h-4"/>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="py-2.5 grow-0 hover:cursor-pointer" v-show="!showSubPackageForm">
                        <div class="flex items-center gap-2 px-2 py-1 transition-all bg-gray-200 bg-opacity-0 rounded text-gray-800/60 hover:bg-opacity-100" @click="handleShowSubPackageForm">
                            <PlusCircleIcon class="w-4 h-4"/>
                            <div class="text-xs font-medium h-min">
                                Tambah Sub Pekerjaan Baru
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
