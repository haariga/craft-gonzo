<template>
  <div class="gonzo-componentView">
    <div class="gonzo-componentHeader bg-white p-10">
      <h1>{{ title }}</h1>
      <p class="text-slate-500">
        {{ store.activeComponent.config.description }}
      </p>
    </div>
    <div class="gonzo-componentRender">
      <render-component :url="url" />
    </div>
    <div class="gonzo-componentFiles mt-10 bg-slate-700">
      <ComponentFiles :files="componentFiles" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useActiveComponentStore } from '@/vue/stores/ActiveComponent';
import { storeToRefs } from 'pinia';
import RenderComponent from '@/vue/components/Component/RenderComponent.vue';
import ComponentFiles from '@/vue/components/Component/ComponentFiles.vue';

const store = useActiveComponentStore();
const { title, files } = storeToRefs(store);

const componentFiles = computed(() => {
  const { twig, config, ...rest } = files.value;
  const html = twig;
  return {
    twig,
    html,
    ...rest,
    config,
  };
});

const url = computed(() => {
  return store.activeComponent.config.slug ?? '';
});
</script>
