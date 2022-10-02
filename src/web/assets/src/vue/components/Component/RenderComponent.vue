<template>
  <iframe
    contenteditable="true"
    :src="url"
    frameborder="0"
    class="w-full h-full"
  ></iframe>
</template>

<script setup lang="ts">
import { computed } from 'vue';

interface IProps {
  url: string;
}

const props = defineProps<IProps>();

const url = computed(() => {
  return '/patternlib/component/render' + props.url;
});
</script>
