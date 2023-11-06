<script setup>
import Modal from '@/Components/Modal.vue'
import { XMarkIcon } from '@heroicons/vue/24/outline'
import { ref } from 'vue'
import Tiptap from '@/Components/Tiptap.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { useForm } from '@inertiajs/vue3'
import TextInput from '@/Components/TextInput.vue'
import InputLabel from '@/Components/InputLabel.vue'

const showModal = ref(false)

const openModal = () => {
    showModal.value = true
}

const closeModal = () =>{
    showModal.value = false
    form.reset()
}

const form = useForm({
    name: '',
    email: '',
    phone: '',
})

const handleSubmit = () => {
    form.post(route('user.store'), {
        preserveScroll: true,
        onSuccess: () => closeModal()
    })
}

defineExpose({
    openModal,
    closeModal
})
</script>

<template>
    <Modal :show="showModal" @close="closeModal" max-width="lg" :closeable="true">
        <form @submit.prevent="handleSubmit">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-100 border-b">
                <h5 class="text-sm font-medium">
                    Tambah User Baru
                </h5>
                <button type="button" @click="closeModal" class="p-[2px] rounded bg-white border">
                    <XMarkIcon class="w-3.5 h-3.5" />
                </button>
            </div>
            <div class="px-4 py-6">
                <div class="mb-2">
                    <InputLabel>Nama User</InputLabel>
                    <TextInput v-model="form.name" :with-border="true"/>
                </div>
                <div class="flex gap-2">
                    <div class="flex-1 mb-2">
                        <InputLabel>Email User</InputLabel>
                        <TextInput v-model="form.email" placeholder="jhon@doe.com" :with-border="true"/>
                    </div>
                    <div class="flex-1 mb-2">
                        <InputLabel>Nomor Telephone</InputLabel>
                        <TextInput v-model="form.phone" placeholder="08123xxx" :with-border="true"/>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t">
                <PrimaryButton type="submit" :disabled="form.processing">Simpan</PrimaryButton>
            </div>
        </form>
    </Modal>
</template>
