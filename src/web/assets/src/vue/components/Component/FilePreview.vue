<template>
  <highlightjs
    :language="lang"
    :code="code"
    className="overflow-scroll w-full"
  />
</template>

<script lang="ts" setup>
import hljsVuePlugin from '@highlightjs/vue-plugin';
import 'highlight.js/styles/atom-one-dark-reasonable.css';
import 'highlight.js/lib/common';

const { component: highlightjs } = hljsVuePlugin;

interface IProps {
  code: string;
  lang: string;
}
defineProps<IProps>();
</script>
