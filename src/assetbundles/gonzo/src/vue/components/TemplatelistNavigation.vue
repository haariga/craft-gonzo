<template>
  <div class="pl-templatelist">
    <div v-for="item in filelist" :key="item.name">
      <Filelist :depth="1" :label="item.name" :nodes="item.children"/>
    </div>
  </div>
</template>

<script>
import Filelist from './Filelist';

export default {
  name: 'TemplatelistNavigation',
  components: { Filelist },
  computed: {
    filelist() {
      return this.$store.state.filelist.items;
    },
  },
};
</script>
