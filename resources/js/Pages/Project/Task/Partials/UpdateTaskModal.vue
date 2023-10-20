<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Tiptap from '@/Components/Tiptap.vue';
import { EllipsisHorizontalIcon, TrashIcon,  UserPlusIcon, XMarkIcon } from '@heroicons/vue/24/outline';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

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
    name: '',
    description: '',
    package_id: null,
    status_id: null,
})

const openModal = (task) => {
    showModal.value = true
    form.name = task.name
    form.description = task.description
    form.status_id = task.status_id
    form.project_id = task.project_id
}

const closeModal = () => {
    showModal.value = false
}

const handleSubmit = () => {
    form.post(route('project.task.store', props.project.data.id), {
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
                    {{ project.data.name }} / Create Task
                </h5>
                <button type="button" @click="closeModal" class="p-[2px] rounded bg-white border">
                    <XMarkIcon class="w-3.5 h-3.5" />
                </button>
            </div>
            <div class="flex flex-row divide-x">
                <div class="basis-3/5 ">
                    <div class="flex flex-row items-center justify-between p-4 border-b">
                        <div class="flex flex-row-reverse">
                            <div class="flex justify-center w-10 h-10 -ml-4 text-white border-2 border-teal-600 border-dashed rounded-full opacity-25 hover:opacity-100 hover:cursor-pointer">
                                <UserPlusIcon class="self-center w-6 h-6 text-teal-600" />
                            </div>
                            <div class="z-10 flex w-10 h-10 -ml-4 text-white bg-teal-600 border rounded-full">
                                <span class="self-center w-full text-center text-[12px]">FA</span>
                            </div>
                            <div class="z-10 flex w-10 h-10 text-white bg-teal-600 border rounded-full">
                                <span class="self-center w-full text-center text-[12px]">FA</span>
                            </div>
                        </div>
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
                                        <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded" >
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
                    <div class="px-4 py-6 h-[70vh] overflow-y-scroll scroll-smooth">
                        <div class="mb-2">
                            <input type="text"
                                class="w-full p-2 -ml-2 text-2xl font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                                v-model="form.name" placeholder="Nama Pekerjaan">
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div class="mb-2">
                            <Tiptap v-model="form.description" placeholder="Tulis deskripsi pekerjaan disini" />
                        </div>
                        <div class="items-form">
                            <div class="flex items-center gap-3 py-2 mb-2">
                                <h6 class="text-base font-medium text-gray-600">Barang & Jasa</h6>
                                <button type="button"
                                    class="py-0.5 px-2 rounded border border-teal-700 text-teal-700 bg-white text-xs">
                                    Add
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-6 w-72 basis-2/5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-light">you membuat item pekerjaan ini.</span>
                        <span class="text-[11px] font-light">Yesterday at 08.00 am</span>
                    </div>
                </div>
            </div>
            <div class="p-4 text-right border-t">
                <PrimaryButton type="submit" :disabled="form.processing">Simpan</PrimaryButton>
            </div>
        </form>
    </Modal>
</template>

<style></style>
