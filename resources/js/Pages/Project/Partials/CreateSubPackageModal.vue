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
    <Modal :show="showModal" @close="closeModal" max-width="lg" :closeable="false">
        <form @submit.prevent="handleSubmit">
            <div class="flex justify-between p-4 border-b">
                <h5 class="text-base font-semibold">
                    Buat Sub Paket Pekerjaan Baru
                </h5>
                <button type="button" @click="closeModal" class="p-[2px] rounded hover:bg-stone-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="px-4 py-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 after:content-['*'] after:text-red-500">
                            Paket Pekerjaan
                        </label>
                        <select v-model="formSubPackage.parent_id"
                            class="block w-full p-0 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                            placeholder="Pilih Paket Pekerjaan" required disabled>
                            <option :value="taskPackage.id" v-for="taskPackage in project.data.packages" :key="taskPackage">{{ taskPackage.name }}</option>
                        </select>
                        <template v-if="errors.parent_id">
                            <span class="text-sm text-red-500">{{ errors.parent_id }}</span>
                        </template>
                    </div>
                    <div class="col-span-2">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 after:content-['*'] after:text-red-500">
                            Nama Sub Paket Pekerjaan
                        </label>
                        <input type="text" v-model="formSubPackage.name"
                            class="block w-full p-0 text-sm text-gray-900 border-t-0 border-gray-300 border-x-0 hover:border-gray-600 focus:border-gray-600 focus:ring-0"
                            placeholder="Nama sub paket pekerjaan" required>
                        <template v-if="errors.name">
                            <span class="text-sm text-red-500">{{ errors.name }}</span>
                        </template>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t">
                <PrimaryButton type="submit" :disabled="formSubPackage.processing">Simpan</PrimaryButton>
            </div>
        </form>
    </Modal>
</template>


<style></style>
