<template>
  <div class="h-full">
    <div class="p-4 border-b border-0 border-solid border-b-slate-800">
      <button
        v-for="tab in tabNames"
        :key="tab"
        @click="changeTab(tab)"
        class="bg-transparent border-0 uppercase font-bold text-slate-400 px-4 py-2 rounded-full"
        :class="{ '!bg-purple-300 text-slate-700': activeTab === tab }"
      >
        {{ tab }}
      </button>
    </div>
    <div class="overflow-scroll h-full">
      <FilePreviewWrapper
        :file-type="activeTab"
        :slug="files[activeTab].path ?? ''"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import type { FileType } from '@/vue/@types/Component';
import FilePreviewWrapper from '@/vue/components/Component/FilePreviewWrapper.vue';
import { useSetUrlParams } from '@/vue/composeables/useSetUrlParams';
import { useActiveComponentStore } from '@/vue/stores/ActiveComponent';
import { storeToRefs } from 'pinia';
import { computed, onMounted, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const route = useRoute();
const store = useActiveComponentStore();
const { slug } = storeToRefs(store);

interface IFile {
  name: string;
  path: string;
  size: number;
}

interface IProps {
  files: {
    twig: IFile;
    html: IFile;
    [key: FileType]: Record<any, any>;
    config: object;
  };
}

const props = defineProps<IProps>();

const tabNames = computed(() => {
  return Object.keys(props.files);
});

const activeTab = ref(route.query.tab ?? 'twig');
const activeIndex = computed(() => {
  return tabNames.value.findIndex((name) => name === activeTab.value);
});

onMounted(() => {
  changeTab(route.query.tab ?? 'twig');
});

watch(route, () => {
  if (!tabNames.value.includes(route.query.tab)) {
    activeTab.value = 'twig';
    changeTab(activeTab.value);
  }
});

function changeTab(tab: string) {
  activeTab.value = tab;
  useSetUrlParams(
    {
      tab,
    },
    router,
    route
  );
}
</script>
