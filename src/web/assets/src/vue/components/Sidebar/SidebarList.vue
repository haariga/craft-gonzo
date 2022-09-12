<template>
  <aside class="gonzo-sidebar">
    <ul>
      <li v-for="comp in store.components" :key="comp.config.title">
        {{ comp.config.title }}
        <SidebarItem :children="comp.children" />
      </li>
    </ul>
  </aside>
</template>

<script setup lang="ts">
import { useMainStore } from '@/vue/stores/Main';
import SidebarItem from '@/vue/components/Sidebar/SidebarItem.vue';

const store = useMainStore();
</script>
