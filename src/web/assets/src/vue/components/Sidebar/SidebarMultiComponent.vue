<template>
  {{ title }}
  <ul>
    <li v-for="component in components" :key="component.config.uuid">
      <SidebarComponent :component="component" />
    </li>
  </ul>
</template>

<script setup lang="ts">
import SidebarComponent, {
  IComponent,
} from '@/vue/components/Sidebar/SidebarComponent.vue';

interface IProps {
  title: string;
  components: IComponent[];
}

defineProps<IProps>();
</script>
