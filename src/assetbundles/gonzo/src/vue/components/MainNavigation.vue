<template>
  <header class="pl-head">
    <nav class="pl-nav">
      <router-link :to="{ name: 'Home' }">Home</router-link>
      <router-link v-for="(pageOptions, page) in patternlibPages" :key="pageOptions.label" :to="`/pages/${page}`">
        {{ pageOptions.label }}
      </router-link>
    </nav>
  </header>
</template>
<script>
export default {
  name: 'MainNavigation',
  computed: {
    patternlibPages() {
      return this.$store.state.pluginSettings.pages;
    },
  },
};
</script>
