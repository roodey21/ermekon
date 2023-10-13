<script setup>
import DangerButton from '@/Components/DangerButton.vue'
import Dropdown from '@/Components/Dropdown.vue'
import Modal from '@/Components/Modal.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import Tiptap from '@/Components/Tiptap.vue'
import { EllipsisHorizontalIcon, TrashIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import { useForm } from '@inertiajs/vue3'
import { ref, watch } from 'vue'

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
})

const showModal = ref(false)

const confirmingDeletePackage = ref(false)

const projectPackage = ref(null)

const form = useForm({
    name: '',
    description: '',
})

const formDelete = useForm({
    id: null
})

const openModal = (id) => {
    projectPackage.value = props.project.data.packages.find((p) => p.id === id)
    form.name = projectPackage.value.name
    form.description = projectPackage.value.description
    showModal.value = true
}

const openDeleteModal = () => {
    confirmingDeletePackage.value = true
}

const closeDeleteModal = () => {
    confirmingDeletePackage.value = false
}

const closeModal = () => {
    showModal.value = false
}

const handleSubmit = () => {
    form.put(route('project.package.update', {
            project: props.project.data.id,
            package: projectPackage.value.id
        }), {
            onSuccess: () => {
                closeModal()
                form.reset()
            }
        })
}

const deletePackage = () => {
    formDelete.delete(route('project.package.destroy', {
            project: props.project.data.id,
            package: projectPackage.value.id
        }), {
            onSuccess: () => {
                closeDeleteModal()
                closeModal()
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
                    Edit Paket Pekerjaan
                </h5>
                <button type="button" @click="closeModal" class="p-[2px] rounded bg-white border">
                    <XMarkIcon class="w-3.5 h-3.5" />
                </button>
            </div>
            <div class="flex flex-row divide-x">
                <div class="basis-3/5">
                    <div class="flex flex-row justify-between p-4 border-b">
                        <div></div>
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
                                        <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded" @click="openDeleteModal">
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
                    <div class="px-4 py-6 overflow-y-scroll">
                        <div class="mb-2">
                            <input type="text"
                                class="w-full p-2 -ml-2 text-2xl font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                                v-model="form.name" placeholder="Nama Paket Pekerjaan">
                        </div>
                        <div class="mb-2">
                            <Tiptap v-model="form.description" />
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
            <div class="p-4 border-t">
                <PrimaryButton type="submit" :disabled="form.processing">Simpan</PrimaryButton>
            </div>
        </form>
    </Modal>
    <Modal :show="confirmingDeletePackage" max-width="sm" @close="closeDeleteModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Apakah anda yakin ingin menghapus paket pekerjaan ini?
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Semua data yang berhubungan dengan paket pekerjaan ini akan dihapus secara permanen.
            </p>

            <div class="flex justify-end mt-6">
                <SecondaryButton @click="closeDeleteModal"> Batal </SecondaryButton>

                <DangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': formDelete.processing }"
                    :disabled="formDelete.processing"
                    @click="deletePackage"
                >
                    Hapus
                </DangerButton>
            </div>
        </div>
    </Modal>
</template>

<style></style>
