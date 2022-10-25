<template>
  <LoadingSpinner v-if="loading" />
  <FilePreview v-if="code && !loading" :code="code" :language="fileType" />
</template>

<script setup lang="ts">
import { api } from '@/js/helpers/api';
import FilePreview from '@/vue/components/Component/FilePreview.vue';
import LoadingSpinner from '@/vue/components/Loading/LoadingSpinner.vue';
import { useActiveComponentStore } from '@/vue/stores/ActiveComponent';
import { onMounted, ref, toRefs, watch } from 'vue';
import { useRoute } from 'vue-router';

interface IProps {
  fileType: string;
  slug: string;
}

const loading = ref(false);
const store = useActiveComponentStore();

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
    variant: store.activeVariant ?? 'Default',
  });

  loading.value = false;

  return data;
}

const props = defineProps<IProps>();
const { fileType, slug } = toRefs(props);

const code = ref('');
const route = useRoute();

async function changePreview() {
  if (fileType.value == 'config') {
    code.value = JSON.stringify(store.activeComponent.config, ' ', 2);
  } else {
    const _slug =
      fileType.value === 'html'
        ? store.activeComponent.config.slug.slice(1)
        : slug.value;
    code.value = await loadData(_slug, fileType.value);
  }
}

onMounted(async () => {
  await changePreview();
});

watch(route, async () => {
  await changePreview();
});
</script>
