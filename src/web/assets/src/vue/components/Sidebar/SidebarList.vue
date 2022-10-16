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
          v-model="searchString"
        />
      </div>
    </header>
    <ul v-if="searchString.length == 0 && searchedComponents.length == 0">
      <li v-for="comp in store.components" :key="comp.config.title">
        {{ comp.config.title }}
        <SidebarItem :children="comp.children" />
      </li>
    </ul>
    <ul v-if="searchString.length > 0 && searchedComponents.length > 0">
      <li v-for="comp in searchedComponents" :key="comp.config.title">
        <SidebarComponent :component="comp" />
      </li>
    </ul>
  </aside>
</template>

<script setup lang="ts">
import { api } from '@/js/helpers/api';
import SidebarComponent from '@/vue/components/Sidebar/SidebarComponent.vue';
import SidebarItem from '@/vue/components/Sidebar/SidebarItem.vue';
import { useMainStore } from '@/vue/stores/Main';
import { ref, watch } from 'vue';

const store = useMainStore();

const searchString = ref('');

const searchedComponents = ref([]);
watch(searchString, async (searchValue) => {
  const {
    data: { results },
  } = await api.post(
    '/actions/craft-gonzo/front-end-routes/search-for-component',
    {
      searchString: searchValue,
    }
  );
  searchedComponents.value = results;
});
</script>
