<script setup>
import Modal from "@/Components/Modal.vue"
import PrimaryButton from "@/Components/PrimaryButton.vue"
import Tiptap from "@/Components/Tiptap.vue"
import { useForm } from "@inertiajs/vue3"
import { nextTick, ref } from "vue"
import { XMarkIcon } from "@heroicons/vue/24/outline"

const props = defineProps({
    project: {
        type: Object,
        required: true
    }
})

const form = useForm({
    name: '',
    description: ''
})

const showModal = ref(false)
const inputName = ref(null)

const openModal = async () => {
    showModal.value = true
    await nextTick()
    inputName.value.focus()
}

const closeModal = () => {
    showModal.value = false
}

const handleSubmit = () => {
    console.log('submitted')
    form.post(route('project.package.store', props.project.data.id), {
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
    <Modal :show="showModal" @close="closeModal" max-width="2xl" :closeable="true">
        <form @submit.prevent="handleSubmit">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-100 border-b">
                <h5 class="text-sm font-medium">
                    Buat Paket Pekerjaan Baru
                </h5>
                <button type="button" @click="closeModal" class="p-[2px] rounded bg-white border">
                    <XMarkIcon class="w-3.5 h-3.5" />
                </button>
            </div>
            <div class="px-4 py-6">
                <div class="mb-2">
                    <input type="text" ref="inputName"
                        class="w-full p-2 -ml-2 text-2xl font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                        v-model="form.name" placeholder="Nama Paket Pekerjaan">
                </div>
                <div class="mb-2">
                    <Tiptap v-model="form.description" />
                    <!-- <textarea rows="8"
                        class="w-full p-2 -ml-2 text-sm font-light text-gray-900 border border-gray-200 border-opacity-0 rounded placeholder:text-gray-600 focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                        placeholder="deskripsi atau catatan lainnya ditulis disini"
                        v-model="form.description"></textarea> -->
                </div>
            </div>
            <div class="p-4 border-t">
                <PrimaryButton type="submit" :disabled="form.processing">Simpan</PrimaryButton>
            </div>
        </form>
    </Modal>
</template>


<style></style>
