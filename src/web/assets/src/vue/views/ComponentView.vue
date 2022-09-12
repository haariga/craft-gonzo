<template>
  <div class="gonzo-componentView">
    <div class="gonzo-componentHeader bg-white p-10">
      <h1>{{ title }}</h1>
      <p class="text-slate-500">
        {{ store.activeComponent.config.description }}
      </p>
    </div>
    <div class="gonzo-componentRender"></div>
    <div class="gonzo-componentFiles bg-white p-10"></div>
  </div>
</template>

<script setup lang="ts">
import { useActiveComponentStore } from '@/vue/stores/ActiveComponent';
import { storeToRefs } from 'pinia';

const store = useActiveComponentStore();
const { title } = storeToRefs(store);
</script>
