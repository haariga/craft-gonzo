<template>
  <ul>
    <li v-for="(child, index) in children" :key="index">
      <template v-if="child.children">
        {{ child.config.title }}
        <SidebarItem :children="child.children" />
      </template>
      <SidebarSub v-if="!child.children" :item="child" />
    </li>
  </ul>
</template>

<script setup lang="ts">
import SidebarSub from '@/vue/components/Sidebar/SidebarSub.vue';
import type { ISectionComponent } from '@/vue/@types/SectionComponent';

interface IProps {
  children: {
    [key: string]: ISectionComponent;
  };
}

defineProps<IProps>();
</script>
