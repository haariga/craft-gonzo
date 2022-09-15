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
import { onBeforeRouteUpdate, RouterView, useRoute } from 'vue-router';
import Sidebar from './components/Sidebar/SidebarList.vue';
import { useMainStore } from '@/vue/stores/Main';
import { useActiveComponentStore } from '@/vue/stores/ActiveComponent';
import { onMounted } from 'vue';

const props = defineProps({
  components: Object,
  activeComponent: Object,
});

const store = useMainStore();
const activeComponent = useActiveComponentStore();
const route = useRoute();

store.addComponents(props.components);
if (props.activeComponent) {
  activeComponent.setActiveComponent(props.activeComponent);
}
const currentYear = new Date().getFullYear();
</script>
