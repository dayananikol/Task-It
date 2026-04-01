<!-- AppLayout.vue -->
<script setup lang="ts">
import AppContent from '@/components/AppContent.vue';
import { router } from '@inertiajs/vue3';
import type { BreadcrumbItemType } from '@/types';

interface Props {
  breadcrumbs?: BreadcrumbItemType[];
}

withDefaults(defineProps<Props>(), {
  breadcrumbs: () => [],
});

// helper function to handle logout
function logout() {
  router.post('/logout');
}

</script>

<template>
  <div class="min-h-screen bg-gray-200"> 
    
    <!-- Header -->
    <header class="bg-black p-6 text-white flex justify-between items-center">
      <span class="font-bold">Task It!</span>

      <button
        @click="logout"
        class="text-white px-3 py-1 rounded-md hover:text-gray-300"
        aria-label="Logout"
      >
        Logout
      </button>
    </header>

    <!-- Page content -->
    <AppContent>
      <slot />
    </AppContent>
  </div>
</template>