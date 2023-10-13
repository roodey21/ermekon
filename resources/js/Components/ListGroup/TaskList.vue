<script setup>
import { nextTick, ref } from 'vue'
import Tooltip from '@/Components/Tooltip.vue'
import { useForm } from '@inertiajs/vue3'

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
                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.99984 8.33341V5.00008M4.99984 5.00008V1.66675M4.99984 5.00008H8.33317M4.99984 5.00008H1.6665" stroke="white" stroke-width="1.16667" stroke-linecap="round"/>
                                </svg>
                            </div>
                        </Tooltip>
                        <Tooltip text="Rename">
                            <div class="p-1 rounded fill white bg-amber-500" @click="handleRename">
                                <svg class="w-2.5 h-2.5" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_141_84)">
                                        <path
                                            d="M1.80542 6.68668L6.90417 1.58752C7.1056 1.39475 7.37451 1.28852 7.6533 1.29157C7.93209 1.29461 8.19861 1.4067 8.39579 1.60382C8.59296 1.80094 8.70512 2.06743 8.70824 2.34622C8.71137 2.62501 8.60521 2.89394 8.4125 3.09543L3.31292 8.1946C3.19658 8.31094 3.04841 8.39025 2.88708 8.42252L1.25 8.75002L1.5775 7.11252C1.60977 6.95119 1.68907 6.80302 1.80542 6.68668Z"
                                            stroke="white" stroke-width="1.16667" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M6.0415 2.70825L7.2915 3.95825" stroke="white" stroke-width="1.16667" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_141_84">
                                            <rect width="10" height="10" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                        </Tooltip>
                        <Tooltip text="Hapus">
                            <div class="p-1 bg-red-700 rounded fill white"
                                @click="showDeleteSubPackage"
                                >
                                <svg class="w-2.5 h-2.5" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M0.833496 2.49992H9.16683M4.16683 4.58325V6.66659M5.8335 4.58325V6.66659M1.66683 2.49992H8.3335L7.67516 8.42492C7.6526 8.62882 7.55561 8.81724 7.40277 8.95409C7.24993 9.09094 7.05198 9.1666 6.84683 9.16659H3.1535C2.94834 9.1666 2.7504 9.09094 2.59756 8.95409C2.44472 8.81724 2.34773 8.62882 2.32516 8.42492L1.66683 2.49992ZM3.06058 1.31117C3.12798 1.16824 3.23462 1.04742 3.36808 0.962798C3.50154 0.878179 3.65631 0.83325 3.81433 0.833252H6.186C6.34409 0.833171 6.49895 0.878063 6.63248 0.962687C6.76602 1.04731 6.87274 1.16817 6.94016 1.31117L7.50016 2.49992H2.50016L3.06058 1.31117Z"
                                        stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
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
