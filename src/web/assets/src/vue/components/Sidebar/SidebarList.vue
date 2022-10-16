<template>
  <aside
    class="gonzo-sidebar h-screen bg-slate-800 text-slate-200 sticky top-0"
  >
    <header class="px-4">
      <h1 class="uppercase">
        Gonzo
        <span class="text-base normal-case text-slate-400 font-normal"
          >Pattern Library</span
        >
      </h1>

      <div class="pr-4">
        <input
          type="text"
          class="bg-slate-600 appearance-none border-0 rounded px-4 py-2 w-full placeholder-slate-300"
          placeholder="Search..."
        />
      </div>
    </header>
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
