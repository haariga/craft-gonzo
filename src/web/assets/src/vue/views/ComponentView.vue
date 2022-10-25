<template>
  <div class="gonzo-componentView">
    <div class="gonzo-componentHeader bg-slate-700 p-10">
      <h1>{{ title }}</h1>
      <p class="text-slate-500">
        {{ store.activeComponent.config.description }}
      </p>
      <ul class="flex list-none space-x-4">
        <li
          v-for="variant in store.activeComponent.config.variants"
          :key="variant.title"
        >
          <button @click="setVariant(variant.title)">
            {{ variant.name }}
          </button>
        </li>
      </ul>
    </div>
    <div class="gonzo-componentRender p-10 bg-white">
      <render-component :url="url" :variant="variant" />
    </div>
    <div class="gonzo-componentFiles mt-10 bg-slate-700">
      <ComponentFiles :files="componentFiles" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { useSetUrlParams } from '@/vue/composeables/useSetUrlParams';
import { computed, onMounted } from 'vue';
import { useActiveComponentStore } from '@/vue/stores/ActiveComponent';
import { storeToRefs } from 'pinia';
import RenderComponent from '@/vue/components/Component/RenderComponent.vue';
import ComponentFiles from '@/vue/components/Component/ComponentFiles.vue';
import { useRoute, useRouter } from 'vue-router';

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

const route = useRoute();
const router = useRouter();
function setVariant(variant: string) {
  useSetUrlParams(
    {
      ...route.query,
      variant: variant,
    },
    router,
    route
  );
  store.setActiveVariant(variant);
}

onMounted(() => {
  setVariant(route.query.variant ?? 'Default');
});

const variant = computed(() => {
  return store.activeComponent.config.variants.find((variant) => {
    return (
      variant.title === store.activeVariant ||
      variant.name === store.activeVariant
    );
  });
});
</script>
