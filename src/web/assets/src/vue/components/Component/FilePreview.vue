<template>
  <highlightjs :language="codeLang" :code="code" className="overflow w-full" />
</template>

<script lang="ts" setup>
import hljsVuePlugin from '@highlightjs/vue-plugin';
import 'highlight.js/styles/atom-one-dark-reasonable.css';
import 'highlight.js/lib/common';
import { computed } from 'vue';

const { component: highlightjs } = hljsVuePlugin;

interface IProps {
  code: string;
  language: string;
}

const langMap = {
  config: 'json',
  twig: 'twig',
  html: 'html',
  ts: 'typescript',
  typescript: 'typescript',
  js: 'javascript',
  javascript: 'javascript',
  sass: 'sass',
  scss: 'scss',
  pcss: 'postcss',
  css: 'css',
};

const props = defineProps<IProps>();

const codeLang = computed(() => {
  return langMap[props.language];
});
</script>
