<script setup lang="ts">
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { TrashIcon, PencilIcon } from '@heroicons/vue/24/outline'

// Receive tasks from controller
const props = defineProps<{
  tasks: {
    id: number
    title: string
    description: string
  }[]
}>()

// Form fields
const title = ref('')
const description = ref('')

// CREATE
function createTask() {
  router.post('/tasks', {
    title: title.value,
    description: description.value,
  }, {
    onSuccess: () => {
      title.value = ''
      description.value = ''
    }
  })
}

// UPDATE
function updateTask(task: any) {
  router.put(`/tasks/${task.id}`, {
    title: task.title,
    description: task.description,
  })
}

// DELETE
function deleteTask(id: number) {
  if (confirm('Delete this task?')) {
    router.delete(`/tasks/${id}`)
  }
}
</script>

<template>
  <AppLayout>
    <div class="w-full p-6">

      <!-- Page title -->
      <h1 class="text-2xl font-bold mb-6">My Tasks</h1>

      <!-- CREATE TASK -->
      <div class="bg-white p-4 rounded-lg shadow mb-6 space-y-3">
        <input
          v-model="title"
          placeholder="Task title"
          class="w-full border rounded p-2"
        />

        <textarea
          v-model="description"
          placeholder="Task description"
          class="w-full border rounded p-2"
        />

        <button
          @click="createTask"
          class="bg-black hover:bg-gray-800 text-white px-4 py-2 rounded-lg transition"
        >
          Add Task
        </button>
      </div>

      <!-- TASK LIST -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div
          v-for="task in props.tasks"
          :key="task.id"
          class="bg-white p-4 rounded-lg shadow"
        >
          <!-- EDITABLE FIELDS -->
          <input
            v-model="task.title"
            class="w-full border rounded p-2 mb-2"
          />

          <textarea
            v-model="task.description"
            class="w-full border rounded p-2 mb-3"
          />

          <!-- ACTION BUTTONS -->
          <div class="flex gap-2">
            <button
              @click="updateTask(task)"
              class="bg-black hover:bg-gray-800 text-white px-3 py-1 rounded"
            >
              Update
            </button>

            <button
              @click="deleteTask(task.id)"
              class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded flex items-center justify-center"
              aria-label="Delete"
            >
              <TrashIcon class="w-5 h-5" />
            </button>
          </div>
        </div>
      </div>

    </div>
  </AppLayout>
</template>