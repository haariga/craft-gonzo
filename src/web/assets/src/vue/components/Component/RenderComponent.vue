<template>
  <iframe
    contenteditable="true"
    :src="url"
    frameborder="0"
    class="max-w-full w-full"
    :height="iFrameSize.height"
    ref="iframe"
  ></iframe>
</template>

<script setup lang="ts">
import type { IComponent } from '@/vue/components/Sidebar/SidebarComponent.vue';
import { computed, onMounted, onUpdated, ref } from 'vue';

interface IProps {
  url: string;
  variant: IComponent;
}

const props = defineProps<IProps>();

const url = computed(() => {
  return '/patternlib/component/render' + props.url + '/' + props.variant.name;
});

const iframe = ref<HTMLIFrameElement | null>(null);
const iFrameSize = ref({
  width: '100%',
  height: '100%',
});

function updateIframe() {
  if (iframe.value) {
    iframe.value.onload = function () {
      iFrameSize.value.width =
        iframe.value.contentWindow.document.body.scrollWidth + 'px';
      iFrameSize.value.height =
        iframe.value.contentWindow.document.body.scrollHeight + 'px';
    };

    const observer = new ResizeObserver(function () {
      iFrameSize.value.width =
        iframe.value.contentWindow.document.body.scrollWidth + 'px';
      iFrameSize.value.height =
        iframe.value.contentWindow.document.body.scrollHeight + 'px';
    });

    observer.observe(iframe.value);
  }
}
onMounted(() => {
  updateIframe();
});

onUpdated(() => {
  updateIframe();
});
</script>
