<template>
  <TabGroup @change="changeTab" :default-index="defaultIndex">
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
import { useSetUrlParams } from '@/vue/composeables/useSetUrlParams';
import { useActiveComponentStore } from '@/vue/stores/ActiveComponent';
import { TabGroup, TabList, Tab, TabPanels, TabPanel } from '@headlessui/vue';
import { FileType } from '@/vue/@types/Component';
import { storeToRefs } from 'pinia';
import { computed, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';

const router = useRouter();
const route = useRoute();
const store = useActiveComponentStore();
const { slug } = storeToRefs(store);

const activeComponentSlug = computed(() => {
  return slug.value.slice(1);
});

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

const defaultIndex = computed(() => {
  const key = route.query.tab ?? 'html';
  return tabNames.value.findIndex((name) => name == key);
});

async function loadData(slug: string, key: string): Promise<string> {
  loading.value = true;
  let url = '/actions/craft-gonzo/front-end-routes/get-file-content';
  let dataKey = 'filePath';
  if (key === 'html') {
    url = '/actions/craft-gonzo/front-end-routes/get-template-render';
    dataKey = 'slug';
  }
  const { data } = await api.post(url, {
    [dataKey]: slug,
  });

  loading.value = false;

  return data;
}

onMounted(async () => {
  const key = route.query.tab ?? 'html';
  const slug =
    key == 'html' ? activeComponentSlug.value : files.value[key].path;
  code.value = await loadData(slug, key);
});

async function changeTab(index: number) {
  loading.value = true;
  const value = files.value[tabNames.value[index]];
  const key = tabNames.value[index];
  let slug = value.path;

  useSetUrlParams(
    {
      tab: key,
    },
    router,
    route
  );
  if (key === 'config') {
    code.value = JSON.stringify(value, ' ', 2);
    loading.value = false;
    return;
  }

  if (key === 'html') {
    slug = activeComponentSlug.value;
  }

  code.value = await loadData(slug, key);
}
</script>
