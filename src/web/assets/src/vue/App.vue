<template>
  <div class="gonzo-layout">
    <header class="gonzo-header px-4">
      <h1 class="uppercase">
        Gonzo
        <span class="text-base normal-case text-slate-400 font-normal"
          >Pattern Library</span
        >
      </h1>
    </header>

    <Sidebar />
    <main class="gonzo-main bg-slate-300 shadow-2xl">
      <RouterView />
    </main>

    <footer class="gonzo-footer px-4">Haariga &copy; {{ currentYear }}</footer>
  </div>
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router';
import Sidebar from './components/Sidebar/SidebarList.vue';
import { useMainStore } from '@/vue/stores/Main';

const props = defineProps({
  components: Object,
});

const store = useMainStore();
store.addComponents(props.components);
const currentYear = new Date().getFullYear();
</script>
