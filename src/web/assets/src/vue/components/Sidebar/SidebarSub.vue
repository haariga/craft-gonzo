<template>
  <component
    :is="hasSubItems ? SidebarMultiComponent : SidebarComponent"
    v-bind="{
      ...(hasSubItems
        ? {
            components: component,
            title: item.title,
          }
        : {
            component,
          }),
    }"
  />
</template>

<script setup lang="ts">
import { computed } from 'vue';
import SidebarComponent from './SidebarComponent.vue';
import SidebarMultiComponent from './SidebarMultiComponent.vue';
import type { ISectionComponent } from '@/vue/stores/Main';

interface IProps {
  item: ISectionComponent;
}

const props = defineProps<IProps>();

const hasSubItems = computed(() => {
  if (props.item.configs.length > 1) {
    return true;
  }

  return false;
});

const component = computed(() => {
  if (hasSubItems.value) {
    return props.item.configs;
  }

  return props.item.configs[0];
});
</script>
