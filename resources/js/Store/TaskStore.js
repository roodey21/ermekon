import { defineStore } from "pinia";

export const useTaskStore = defineStore('task', {
    state: () => ({
        showTaskModal: false,
        task: null
    }),
    actions: {
        toggleTaskModal() {
            this.showTaskModal = !this.showTaskModal;
        },
        setTask(task) {
            this.task = task;
        }
    }
})
