<template>
  <div class="pl-templatelist">
    <div v-for="item in filelist" v-show="sidebar" :key="item.name">
      <Filelist :depth="1" :label="item.name" :nodes="item.children"/>
    </div>
  </div>
</template>

<script>
import Filelist from '@Components/Filelist';

export default {
  name: 'TemplatelistNavigation',
  components: { Filelist },
  computed: {
    filelist() {
      return this.$store.state.filelist;
    },
  },
};
</script>
