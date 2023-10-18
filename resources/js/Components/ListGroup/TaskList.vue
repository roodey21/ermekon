<script setup>
import { nextTick, ref } from 'vue'
import Tooltip from '@/Components/Tooltip.vue'
import { useForm } from '@inertiajs/vue3'
import { PencilIcon, PlusIcon, TrashIcon } from '@heroicons/vue/24/outline';

const editNameInput = ref(null)
const showEditName = ref(false)
const showEditNameForm = ref(false)
const showList = ref(true)

const props = defineProps({
    packageId: {
        type: Number,
        required: true
    },
    subpackage: {
        type: Object,
        required: true
    },
    projectId: {
        type: Number,
        required: true
    }
})

const emit = defineEmits(['showAddItem','showDeleteSubPackage'])

const showAddItem = () => {
    emit('showAddItem', [props.packageId, props.subpackage.id])
}

const showDeleteSubPackage = () => {
    emit('showDeleteSubPackage', props.subpackage.id)
}

const handleRename = async () => {
    showEditNameForm.value = true
    showEditName.value = false
    await nextTick()
    editNameInput.value.focus()
}

const handleMouseEnter = () => {
    if (isTextareaFocused()) return
    showEditName.value = true
}

const handleMouseLeave = () => {
    showEditName.value = false
}

const isTextareaFocused = () => {
    return editNameInput.value === document.activeElement
}

const updateNameForm = useForm({
    name:''
})

const updateNameSubPackage = () => {
    updateNameForm.name = editNameInput.value.value
    updateNameForm.put(route('project.package.update', [props.projectId, props.subpackage.id]), {
        onSuccess: () => {
            showEditNameForm.value = false
        }
    })
}
</script>
<template>
    <div class="flex flex-col">
        <div class="flex px-8 border-b border-gray-200 hover:bg-gray-100 hover:cursor-pointer" @mouseenter="handleMouseEnter" @mouseleave="handleMouseLeave">
            <div class="py-3.5 grow">
                <div class="flex items-center gap-2">
                    <div class="transition-all duration-300" @click="showList=!showList" :class="{'rotate-90':showList, 'opacity-0':!subpackage.tasks.length}">
                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M6.99984 12.8334C10.2215 12.8334 12.8332 10.2217 12.8332 7.00008C12.8332 3.77842 10.2215 1.16675 6.99984 1.16675C3.77818 1.16675 1.1665 3.77842 1.1665 7.00008C1.1665 10.2217 3.77818 12.8334 6.99984 12.8334Z"
                                stroke="black" stroke-width="1.16667" />
                            <path d="M6.125 4.66675L8.45833 7.00008L6.125 9.33341" stroke="black" stroke-width="1.16667"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <form @submit.prevent="updateNameSubPackage" class="flex items-center w-full" v-show="showEditNameForm">
                        <input class="p-0 text-sm font-medium bg-transparent border-none grow focus:ring-0" ref="editNameInput"
                            @blur="showEditNameForm=false"
                            :value="subpackage.name"/>
                    </form>
                    <div class="text-sm font-medium h-min hover:text-emerald-700" v-show="!showEditNameForm">
                        {{ subpackage.name }}
                    </div>
                    <div class="flex gap-1" style="display: none;" v-show="showEditName">
                        <Tooltip text="Tambah Item" v-if="!subpackage.tasks.length">
                            <div class="p-1 rounded fill white bg-emerald-700" @click="showAddItem">
                                <PlusIcon class="w-2.5 h-2/5 text-white" />
                            </div>
                        </Tooltip>
                        <Tooltip text="Rename">
                            <div class="p-1 rounded fill white bg-amber-500" @click="handleRename">
                                <PencilIcon class="w-2.5 h-2.5 text-white" />
                            </div>
                        </Tooltip>
                        <Tooltip text="Hapus">
                            <div class="p-1 bg-red-700 rounded fill white"
                                @click="showDeleteSubPackage"
                                >
                                <TrashIcon class="w-2.5 h-2.5 text-white" />
                            </div>
                        </Tooltip>
                    </div>
                </div>
            </div>
        </div>
        <div class="" v-show="showList">
            <slot/>
            <div class="flex pl-16 pr-8 border-b border-gray-200 table-header" :class="{'hidden':!subpackage.tasks.length}">
                <div class="py-2.5 grow-0 hover:cursor-pointer" @click="showAddItem">
                    <div class="flex items-center gap-2 px-2 py-1 transition-all bg-gray-200 bg-opacity-0 rounded text-gray-800/60 hover:bg-opacity-100">
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
        </div>
    </div>
</template>
