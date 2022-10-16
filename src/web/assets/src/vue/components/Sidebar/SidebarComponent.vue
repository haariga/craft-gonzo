<template>
  <router-link
    class="text-slate-200"
    :to="slug"
    @click.prevent="handleClick(slug, component)"
  >
    {{ component.config.title }}
  </router-link>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useActiveComponentStore } from '@/vue/stores/ActiveComponent';

type FileType = 'twig' | 'pcss' | 'css' | 'scss' | 'sass' | 'ts' | 'js';

export interface IFile {
  name: string;
  size: number;
}

export interface IConfig {
  description: string;
  fileIdentifier: string;
  slug: string;
  status: string;
  templatePath: string;
  title: string;
  uuid: string;
}

export interface IComponent {
  config: IConfig;
  files: {
    [key: FileType]: IFile[];
  };
}

interface IProps {
  component: IComponent;
}

const props = defineProps<IProps>();

const router = useRouter();
const route = useRoute();
const store = useActiveComponentStore();

const slug = computed(() => {
  return '/component' + props.component.config.slug;
});

function handleClick(target: string, component: IComponent) {
  router.push({
    path: target,
    query: {
      ...route.query,
    },
  });
  store.setActiveComponent(component);
}
</script>
