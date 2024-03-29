<template>
  <div class="gonzo-componentView">
    <div class="gonzo-componentHeader bg-slate-700 p-10">
      <ComponentHeader
        :variants="store.activeComponent.config.variants"
        :status="store.activeComponent.config.status"
        :model-value="activeVariant"
        @update:modelValue="setVariant"
      />
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
import ComponentHeader from '@/vue/components/Component/ComponentHeader.vue';
import type { IComponent } from '@/vue/components/Sidebar/SidebarComponent.vue';

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
  return store.activeComponent.config.variants.find((variant: IComponent) => {
    return (
      variant.title === store.activeVariant ||
      variant.name === store.activeVariant
    );
  });
});

const activeVariant = computed(() => {
  return variant.value?.name ?? 'Default';
});
</script>

<style>
.gonzo-componentView {
  display: grid;
  grid-template-rows: max-content minmax(50vh, 80vh) max(450px);
  overflow: hidden;
  grid-template-areas:
    'componentHeader'
    'componentRender'
    'componentFiles';
}

.gonzo-componentHeader {
  grid-area: componentHeader;
}

.gonzo-componentRender {
  grid-area: componentRender;
  overflow-y: scroll;
}

.gonzo-componentFiles {
  grid-area: componentFiles;
  max-width: calc(100vw - 340px);
}
</style>
