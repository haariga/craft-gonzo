<template>
  <header></header>

  <main>
    <RouterView />
  </main>

  <footer></footer>
</template>

<script setup lang="ts">
import { RouterView } from 'vue-router';
import { useMainStore } from './stores/Main';

const props = defineProps({
  components: Object,
});

const store = useMainStore();
store.addComponents(props.components);
</script>
