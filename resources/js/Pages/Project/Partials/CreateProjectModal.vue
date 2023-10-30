<script setup>
import Modal from '@/Components/Modal.vue'
import { useForm } from '@inertiajs/vue3'
import { ref, computed } from 'vue'
import {
    Combobox,
    ComboboxInput,
    ComboboxButton,
    ComboboxOptions,
    ComboboxOption,
    TransitionRoot,
} from '@headlessui/vue'
import { CheckIcon, ChevronUpDownIcon, XMarkIcon } from '@heroicons/vue/20/solid'
import PrimaryButton from '@/Components/PrimaryButton.vue'

const showModal = ref(false)

const openModal = () => {
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
}

const form = useForm({
    name: '',
    client_name: '',
    client_telephone: '',
})

const people = [
  { id: 1, name: 'Wade Cooper' },
  { id: 2, name: 'Arlene Mccoy' },
  { id: 3, name: 'Devon Webb' },
  { id: 4, name: 'Tom Cook' },
  { id: 5, name: 'Tanya Fox' },
  { id: 6, name: 'Hellen Schmidt' },
]

let selected = ref(people[0])
let query = ref('')

let filteredPeople = computed(() =>
  query.value === ''
    ? people
    : people.filter((person) =>
        person.name
          .toLowerCase()
          .replace(/\s+/g, '')
          .includes(query.value.toLowerCase().replace(/\s+/g, ''))
      )
)

const queryPerson = computed(() => {
    return query.value === '' ? null : { id: null, name: query.value }
  })

const handleSubmit = () => {
    console.log(form)
}

const addNewPerson = () => {
    const newPerson = { id: Date.now(), name: form.client_name };

    // Menambahkan objek data baru ke filteredPeople
    filteredPeople.value.push(newPerson);

    // Mereset form
    form.client_name = '';
    query = '';

    // Menutup ComboboxOptions
    // $refs.combobox.close();
}

defineExpose({
    openModal,
    closeModal,
})
</script>

<template>
    <Modal :show="showModal" @close="closeModal">
        <form @submit.prevent="handleSubmit">
            <div class="flex items-center justify-between px-4 py-3 bg-gray-100 border-b">
                <h5 class="text-sm font-medium">
                    Buat Proyek Baru
                </h5>
                <button type="button" @click="closeModal" class="p-[2px] rounded bg-white border">
                    <XMarkIcon class="w-3.5 h-3.5" />
                </button>
            </div>
            <div class="px-4 py-6">
                <div class="mb-2">
                    <input type="text"
                        class="w-full p-2 -ml-2 text-2xl font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                        v-model="form.name"
                        placeholder="Nama Proyek">
                </div>
                <div class="mb-2">
                    <div class="flex flex-row gap-2">
                        <div class="flex-1">
                            <label for="name"
                                class="block text-xs font-medium text-gray-900 after:content-['*'] after:text-red-500 mb-1">
                                Nama Kustomer
                            </label>
                            <Combobox v-model="selected" ref="combobox" class="w-full -ml-2" nullable>
                                <div class="relative mt-1">
                                    <div
                                    class="relative w-full overflow-hidden text-left bg-white border border-gray-200 border-opacity-0 rounded cursor-default hover:border-opacity-100 focus-within:border-gray-400 focus-within:border-opacity-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-opacity-75 focus-visible:ring-black focus-visible:ring-offset-teal-300 focus-visible:ring-offset-2 sm:text-sm"
                                    >
                                    <ComboboxInput
                                        class="w-full py-1.5 rounded pl-2 pr-10 text-sm leading-5 text-gray-900 border-none focus:ring-0"
                                        :displayValue="(person) => person.name"
                                        @change="query = $event.target.value"
                                    />
                                    <ComboboxButton
                                        class="absolute inset-y-0 right-0 flex items-center pr-2"
                                    >
                                        <ChevronUpDownIcon
                                        class="w-5 h-5 text-gray-400"
                                        aria-hidden="true"
                                        />
                                    </ComboboxButton>
                                    </div>
                                    <TransitionRoot
                                    leave="transition ease-in duration-100"
                                    leaveFrom="opacity-100"
                                    leaveTo="opacity-0"
                                    @after-leave="query = ''"
                                    >
                                    <ComboboxOptions
                                        class="absolute w-full py-1 mt-1 overflow-auto text-base bg-white rounded shadow-md max-h-60 ring-1 ring-black/5 focus:outline-none sm:text-sm"
                                    >
                                        <ComboboxOption
                                        v-if="queryPerson"
                                        v-slot="{ selected, active }"
                                        :value="queryPerson"
                                        >
                                            <li
                                                class="relative py-2 pl-10 pr-4 cursor-default select-none"
                                                :class="{
                                                'bg-teal-600 text-white': active,
                                                'text-gray-900': !active,
                                                }"
                                            >
                                                <span
                                                class="block truncate"
                                                :class="{ 'font-medium': selected, 'font-normal': !selected }"
                                                >
                                                Tambahkan {{ query }}
                                                </span>
                                                <span
                                                v-if="selected"
                                                class="absolute inset-y-0 left-0 flex items-center pl-3"
                                                :class="{ 'text-white': active, 'text-teal-600': !active }"
                                                >
                                                Tambahkan {{ query }}
                                                </span>
                                            </li>
                                        </ComboboxOption>

                                        <ComboboxOption
                                        v-for="person in filteredPeople"
                                        as="template"
                                        :key="person.id"
                                        :value="person"
                                        v-slot="{ selected, active }"
                                        >
                                        <li
                                            class="relative py-2 pl-10 pr-4 cursor-default select-none"
                                            :class="{
                                            'bg-teal-600 text-white': active,
                                            'text-gray-900': !active,
                                            }"
                                        >
                                            <span
                                            class="block truncate"
                                            :class="{ 'font-medium': selected, 'font-normal': !selected }"
                                            >
                                            {{ person.name }}
                                            </span>
                                            <span
                                            v-if="selected"
                                            class="absolute inset-y-0 left-0 flex items-center pl-3"
                                            :class="{ 'text-white': active, 'text-teal-600': !active }"
                                            >
                                            <CheckIcon class="w-5 h-5" aria-hidden="true" />
                                            </span>
                                        </li>
                                        </ComboboxOption>
                                    </ComboboxOptions>
                                    </TransitionRoot>
                                </div>
                            </Combobox>
                        </div>
                        <div class="flex-1">
                            <label for="name"
                                class="block text-xs font-medium text-gray-900 after:content-['*'] after:text-red-500 mb-1">
                                Telepon Kustomer
                            </label>
                            <input type="text"
                                class="w-full px-2 py-1.5 -ml-2 text-sm font-light text-gray-900 border border-gray-200 border-opacity-0 rounded focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                                v-model="form.client_telephone"
                                placeholder="Nomor Telepon">
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <textarea
                        rows="8"
                        class="w-full p-2 -mx-2 text-sm font-light text-gray-900 border border-gray-200 border-opacity-0 rounded placeholder:text-gray-400 focus:ring-0 focus:border-gray-400 hover:border-opacity-100"
                        placeholder="Deskripsi atau catatan lainnya ditulis disini"
                        v-model="form.description"></textarea>
                </div>
            </div>
            <div class="p-4 border-t">
                <PrimaryButton type="submit" :disabled="form.processing">Simpan</PrimaryButton>
            </div>
        </form>
    </Modal>
</template>
