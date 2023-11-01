<script setup>
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    project: {
        type: Object,
        required: true
    },
});

const showEditProjectModal = ref(false);

const openModal = () => {
    showEditProjectModal.value = true;
};

const closeEditProjectModal = () => {
    showEditProjectModal.value = false;
};

const handleSubmitUpdateProject = () => {
    editProjectForm.put(route('project.update', props.project.data.id), {
        onSuccess: () => {
            closeEditProjectModal()
        }
    })
};

const editProjectForm = useForm({
    name: props.project.data.name,
    client_name: props.project.data.client_name,
    client_telephone: props.project.data.client_telephone,
    description: ''
});

defineExpose({
    openModal,
});
</script>

<template>
    <Modal :show="showEditProjectModal" @close="closeEditProjectModal" max-width="6xl" :closeable="false">
        <form @submit.prevent="handleSubmitUpdateProject">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-100 border-b">
                <h5 class="text-sm font-medium">
                    Edit Proyek
                </h5>
                <button type="button" @click="closeEditProjectModal" class="p-[2px] rounded bg-white border">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3.5 h-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex flex-row divide-x">
                <div class="basis-full md:basis-3/5">
                    <!-- <div class="flex flex-row justify-between px-4 py-6 border-b">
                        <div></div>
                        <div class="relative rounded" >
                            <div class="flex items-center gap-2 hover:cursor-pointer group" @click="showMenuPackage=true">
                                <EllipsisHorizontalIcon class="w-6 h-6 transition-all group-hover:text-teal-700 group-hover:scale-125" :class="{'text-teal-700 scale-110': showMenuPackage}"/>
                            </div>
                            <div v-show="showMenuPackage" class="fixed inset-0 z-40" @click="showMenuPackage=false"></div>
                            <div v-show="showMenuPackage" class="absolute right-0 z-50 translate-y-full bg-white border rounded shadow w-52 -bottom-1">
                                <ul class="p-1.5 text-black">
                                    <li class="px-3 py-1.5 hover:bg-gray-100 hover:cursor-pointer group rounded">
                                        <div class="flex items-center gap-2 text-xs text-red-700">
                                            <TrashIcon class="w-3 h-3" />
                                            <span>Hapus Paket Pekerjaan</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div> -->
                    <div class="px-4 py-6">
                        <div class="mb-2">
                            <input type="text"
                                class="w-full p-2 -ml-2 text-2xl font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                                v-model="editProjectForm.name"
                                placeholder="Nama Proyek">
                        </div>
                        <div class="mb-2">
                            <div class="flex flex-row gap-2">
                                <div class="flex-1">
                                    <label for="name"
                                        class="block text-xs font-medium text-gray-900 after:content-['*'] after:text-red-500 mb-1">
                                        Nama Kustomer
                                    </label>
                                    <input type="text"
                                        class="w-full px-2 py-1.5 -ml-2 text-sm font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                                        v-model="editProjectForm.client_name"
                                        placeholder="Nama Kustomer">
                                </div>
                                <div class="flex-1">
                                    <label for="name"
                                        class="block text-xs font-medium text-gray-900 after:content-['*'] after:text-red-500 mb-1">
                                        Telepon Kustomer
                                    </label>
                                    <input type="text"
                                        class="w-full px-2 py-1.5 -ml-2 text-sm font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                                        v-model="editProjectForm.client_telephone"
                                        placeholder="Nomor Telepon">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hidden w-full px-4 py-6 md:w-72 basis-full md:block md:basis-2/5">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-light">you membuat item pekerjaan ini.</span>
                        <span class="text-[11px] font-light">Yesterday at 08.00 am</span>
                    </div>
                </div>
            </div>
            <div class="p-4 border-t">
                <PrimaryButton type="submit" :disabled="editProjectForm.processing">Simpan</PrimaryButton>
            </div>
        </form>
    </Modal>
</template>

<style>

</style>
