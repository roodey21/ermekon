<script setup>
import { MagnifyingGlassIcon, UserPlusIcon, XMarkIcon } from "@heroicons/vue/24/outline";
import { nextTick, onMounted, onUnmounted, ref } from "vue";
import Tooltip from "./Tooltip.vue";

const showInputUser = ref(false)
const inputUserName = ref(null)

const open = () => {
    showInputUser.value = true
    nextTick(() => {
        inputUserName.value.focus()
    })
}

const close = () => {
    showInputUser.value = false
}

const closeOnEscape = (e) => {
    if (e.key === 'Escape') {
        close();
    }
};

const users = ref([])

let searchTimeout

const searchUser = () => {
    clearTimeout(searchTimeout)
    searchTimeout = setTimeout(() => {
        axios.get(route('api.get-users'), {
            params: {
                name: inputUserName.value.value
            }
        }).then(response => {
            users.value = response.data
        })
    }, 300)
}

const selectedUser= ref([])

const getInitial = (fullName) => {
    const words = fullName.split(' ');
    const initialsArray = words.map(word => word[0].toUpperCase());
    return initialsArray.join('');
};

const addUser = (user) => {
    if (selectedUser.value.find(u => u.id === user.id)) {
        close()
        return
    }
    selectedUser.value.push(user)
    close()
}

const clearSelectedUser = () => {
    selectedUser.value = []
}

const deleteUser = (id) => {
    selectedUser.value = selectedUser.value.filter(user => user.id !== id)
}

onMounted(() => document.addEventListener('keydown', closeOnEscape))

onUnmounted(() => {
    document.removeEventListener('keydown', closeOnEscape);
})

defineExpose({
    open,
    close,
    selectedUser,
    clearSelectedUser,
})
</script>

<template>
    <div class="flex flex-row-reverse">
        <div class="relative">
            <div class="flex justify-center w-10 h-10 text-white border-2 border-teal-600 border-dashed rounded-full opacity-25 hover:opacity-100 hover:cursor-pointer"
                :class="{'-ml-4': selectedUser }"
                @click="open">
                <UserPlusIcon class="self-center w-6 h-6 text-teal-600" />
            </div>
            <template v-if="showInputUser">
                <div class="fixed inset-0 z-30 bg-gray-900/10" @click="showInputUser = false"></div>
                <div class="absolute z-40 translate-y-full -bottom-2">
                    <div class="w-64 pb-4 bg-white border rounded-lg shadow-lg">
                        <div class="flex items-center px-4 py-2 border-b">
                            <MagnifyingGlassIcon class="w-4 h-4 text-gray-500" />
                            <input type="text" class="w-full p-2 text-sm border-0 focus:ring-0"
                                placeholder="Cari nama user" ref="inputUserName" @input="searchUser">
                        </div>
                        <ul class="py-1">
                            <li class="relative px-4 py-2 hover:bg-gray-100 hover:cursor-pointer" v-for="user in users.data" :key="user.id" @click="addUser(user)">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="flex items-center justify-center w-8 h-8 text-xs text-white bg-teal-600 rounded-full">
                                        {{ getInitial(user.name) }}</div>
                                    <span class="text-sm font-medium">{{ user.name }}</span>
                                    <div class="absolute right-2">
                                        <template v-if="!selectedUser.find(u => u.id == user.id)">
                                            <span class="py-1 px-2 bg-teal-600 text-[10px] text-white rounded">Add</span>
                                        </template>
                                        <template v-else>
                                            <span class="py-[2px] px-1 bg-white border border-teal-600 text-teal-600 text-[10px] rounded">Added</span>
                                        </template>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </template>
        </div>
        <div class="relative z-10 flex items-center justify-center w-10 h-10 -ml-4 text-white bg-teal-600 border-2 rounded-full group last:ml-0 hover:cursor-pointer" v-for="user in selectedUser" :key="user.id">
            <Tooltip :text="user.name" position="bottom">
                <span class="w-full text-[12px]">{{ getInitial(user.name) }}</span>
            </Tooltip>
            <div class="absolute z-10 invisible transition-all -top-2 -right-2 group-hover:visible" @click="deleteUser(user.id)">
                <div class="p-[2px] top-0 rounded-full text-white bg-gray-400 border-2 border-white">
                    <XMarkIcon class="w-3 h-3"/>
                </div>
            </div>
        </div>
    </div>
</template>
