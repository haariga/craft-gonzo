<template>
  <TabGroup @change="changeTab">
    <TabList>
      <Tab v-for="tab in tabNames" :key="tab">
        {{ tab }}
      </Tab>
    </TabList>
    <TabPanels>
      <TabPanel v-for="panel in tabNames" :key="panel">
        <div class="max-w-full">
          <Loading v-if="loading" />
          <FilePreview
            v-if="code && !loading"
            :code="code"
            :lang="langMap[panel] ?? 'html'"
          />
        </div>
      </TabPanel>
    </TabPanels>
  </TabGroup>
</template>

<script setup lang="ts">
import { api } from '@/js/helpers/api';
import FilePreview from '@/vue/components/Component/FilePreview.vue';
import Loading from '@/vue/components/Loading/LoadingSpinner.vue';
import { useActiveComponentStore } from '@/vue/stores/ActiveComponent';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue';
import { FileType } from '@/vue/@types/Component';
import { computed, ref } from 'vue';

const store = useActiveComponentStore();

interface IProps {
  files: {
    [key: FileType]: Record<any, any> | Array<Record<any, any>>;
  };
}

const props = defineProps<IProps>();
const langMap = {
  config: 'json',
  twig: 'twig',
  html: 'html',
  ts: 'typescript',
  js: 'javascript',
  sass: 'sass',
  scss: 'scss',
  pcss: 'postcss',
  css: 'css',
};

const files = ref({
  html: props.files.twig,
  twig: props.files.twig,
  ...props.files,
});

const tabNames = computed(() => {
  return Object.keys(files.value);
});

const code = ref('');
const loading = ref(false);

async function changeTab(index: number) {
  loading.value = true;
  const value = files.value[tabNames.value[index]];
  console.log(value);
  const key = tabNames.value[index];

  if (key === 'config') {
    code.value = JSON.stringify(value, ' ', 2);
    loading.value = false;
    return;
  }

  if (key == 'html') {
    const { data } = await api.post(
      '/actions/craft-gonzo/front-end-routes/get-template-render',
      {
        slug: store.activeComponent.config.slug.slice(1),
      }
    );
    code.value = data;
    loading.value = false;
    return;
  }

  const { data } = await api.post(
    '/actions/craft-gonzo/front-end-routes/get-file-content',
    {
      filePath: value.path,
    }
  );
  code.value = data;
  loading.value = false;
}
</script>
