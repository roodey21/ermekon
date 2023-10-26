<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Tiptap from '@/Components/Tiptap.vue';
import { CloudArrowUpIcon, EllipsisHorizontalIcon, TrashIcon,  UserPlusIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { router, useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import AssignUserInput from '@/Components/AssignUserInput.vue';

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
    taskStatuses: {
        type: Object,
    },
    errors: Object
})

const showModal = ref(false)

const form = useForm({
    id: null,
    name: '',
    description: '',
    package_id: null,
    start_date: null,
    due_date: null,
    completed_date: null,
    status_id: null,
    files: [],
    assignees: [],
})

const userInput = ref(null)

const openModal = (task) => {
    showModal.value = true
    form.id = task.id
    form.name = task.name
    form.description = task.description
    form.status_id = task.status_id
    form.project_id = task.project_id
    form.start_date = task.start_date
    form.due_date = task.due_date
    form.completed_date = task.completed_date
    form.assignees = task.assignees
    nextTick(() => {
        userInput.value.selectedUser = task.assignees
    })
}

const closeModal = () => {
    showModal.value = false
}

const handleSubmit = () => {
    form.assignees = userInput.value.selectedUser
    form.put(route('project.task.update', [props.project.data.id, form.id]), {
        onSuccess: () => {
            closeModal()
            form.reset()
        }
    })
}

const handleDelete = () => {
    router.delete(route('project.task.destroy', [props.project.data.id, form.id]), {
        onSuccess: () => {
            closeModal()
            form.reset()
        }
    })
}

defineExpose({
    openModal,
    closeModal
})
</script>

<template>
    <Modal :show="showModal" @close="closeModal" max-width="6xl" :closeable="false">
        <form @submit.prevent="handleSubmit">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-100 border-b">
                <h5 class="text-sm font-medium">
                    {{ project.data.name }} / Update Task / {{ form.name }}
                </h5>
                <button type="button" @click="closeModal" class="p-[2px] rounded bg-white border">
                    <XMarkIcon class="w-3.5 h-3.5" />
                </button>
            </div>
            <div class="flex flex-row divide-x">
                <div class="basis-3/5">
                    <div class="flex flex-row items-center justify-between p-4 border-b">
                        <AssignUserInput ref="userInput"/>
                        <div>
                            <Dropdown align="left">
                                <template #trigger>
                                    <div class="group hover:cursor-pointer">
                                        <EllipsisHorizontalIcon
                                            class="w-6 h-6 transition-all group-hover:text-teal-700 group-hover:scale-125"/>
                                    </div>
                                </template>

                                <template #content>
                                    <ul class="p-1.5 text-black">
                                        <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded" @click="handleDelete">
                                            <div class="flex items-center gap-2 text-xs text-red-700">
                                                <TrashIcon class="w-3 h-3" />
                                                <span>Hapus Paket Pekerjaan</span>
                                            </div>
                                        </li>
                                    </ul>
                                </template>
                            </Dropdown>
                        </div>
                    </div>
                    <div class="px-4 py-6 h-[70vh] overflow-y-scroll">
                        <div class="mb-3">
                            <input type="text"
                                class="w-full p-2 text-2xl font-light text-gray-900 border border-gray-200 rounded focus:ring-0 focus:border-teal-700 hover:border-opacity-100"
                                v-model="form.name" placeholder="Nama Pekerjaan">
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mb-3">
                            <Tiptap v-model="form.description" placeholder="Tulis deskripsi pekerjaan disini" :show-border="true" margin="ml-0"/>
                        </div>
                        <div class="flex gap-2">
                            <div class="flex-1 mb-3">
                                <label for="" class="text-xs text-gray-800">Tanggal Mulai</label>
                                <input type="date"
                                    v-model="form.start_date"
                                    class="w-full p-2 text-sm font-light text-gray-900 border border-gray-200 rounded focus:ring-0 focus:border-teal-700 hover:border-opacity-100"
                                    placeholder="Nama Pekerjaan">
                            </div>
                            <div class="flex-1 mb-3">
                                <label for="" class="text-xs text-gray-800">Tanggal Selesai</label>
                                <input type="date"
                                    v-model="form.due_date"
                                    class="w-full p-2 text-sm font-light text-gray-900 border border-gray-200 rounded focus:ring-0 focus:border-teal-700 hover:border-opacity-100"
                                    placeholder="Nama Pekerjaan">
                            </div>
                        </div>
                        <div class="items-form">
                            <div class="flex items-center gap-3 py-2 mb-2">
                                <h6 class="text-base font-medium text-gray-600">File & Dokumen</h6>
                                <button type="button"
                                    class="py-0.5 px-2 rounded border border-teal-700 text-teal-700 bg-white text-xs"
                                    @click="addFileInput">
                                    Add
                                </button>
                            </div>
                            <div class="grid grid-cols-4 gap-4">
                                <label v-for="(file, index) in form.files" :key="index" class="relative flex flex-col items-center justify-center overflow-hidden border-2 border-gray-300 border-dashed rounded-lg cursor-pointer aspect-square bg-gray-50 hover:bg-gray-100">
                                    <template v-if="form.files[index]">
                                        <div class="flex flex-col items-center justify-center w-full gap-2 px-2 pt-5 pb-6">
                                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                                                <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"/>
                                                <path d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2Z"/>
                                            </svg>
                                            <p class="text-sm text-gray-500 break-all"><span class="font-semibold">{{ file.name }}</span></p>
                                        </div>
                                    </template>
                                    <template v-else>
                                        <div class="flex flex-col items-center justify-center w-full px-2 pt-5 pb-6">
                                            <CloudArrowUpIcon class="w-8 h-8 text-gray-500" />
                                            <p class="mb-2 text-sm text-gray-500 break-all"><span class="font-semibold">Click to upload</span></p>
                                        </div>
                                    </template>
                                    <div class="absolute top-0 right-0 z-40">
                                        <div class="flex items-center justify-center p-1 pb-2 pl-2 rounded-bl-full hover:bg-red-400 group" @click.prevent="removeFileInput(index)">
                                            <XMarkIcon class="w-4 h-4 text-gray-500 group-hover:text-white" />
                                        </div>
                                    </div>
                                    <input type="file" @input="form.files[index] = $event.target.files[0]; console.log($event.target.files)" class="hidden"/>
                                    <!-- <input type="file" @input="console.log($event.target.files)" class="hidden" :class="'file-'+index"/> -->
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="h-16 p-4 text-right border-t">
                        <PrimaryButton type="submit" :disabled="form.processing">Simpan</PrimaryButton>
                    </div>
                </div>
                <div class="relative flex flex-col w-72 basis-2/5">
                    <div class="flex flex-row items-center justify-between p-4 border-b">
                        <div class="h-10"></div>
                    </div>
                    <div class="px-4 py-6 space-y-20 overflow-y-scroll max-h-[70vh]">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-light">you membuat item pekerjaan ini.</span>
                            <span class="text-[11px] font-light">Yesterday at 08.00 am</span>
                        </div>
                    </div>
                    <div class="absolute inset-x-0 bottom-0 p-4 bg-white border-t min-h-16">
                        <Tiptap />
                        <!-- <PrimaryButton type="submit" :disabled="form.processing">Simpan</PrimaryButton> -->
                    </div>
                </div>
            </div>
        </form>
    </Modal>
</template>

<style></style>
