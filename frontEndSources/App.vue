<template>
  <div class="gonzo">
    <Filelist :nodes="filelist" />
    <PreviewArea />
  </div>
</template>

<script>
import Filelist from 'Modules/Filelist/Filelist';
import PreviewArea from 'Modules/PreviewArea/PreviewArea';

export default {
  name: 'Styleguide',
  components: {
    Filelist,
    PreviewArea,
  },
  computed: {
    filelist() {
      return this.$store.getters.filelist;
    },
  },
  mounted() {
    this.$store.dispatch('setFilelist', window.filelist);
  },
};
</script>

<style lang="scss">
body {
  background-color: #f4f6f8;
  font-family: Lato;
  padding: 20px;
}

.gonzo {
  position: relative;
  display: grid;
  grid-template-columns: 250px 1fr;
}
</style>
