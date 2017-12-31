
<template>
  <div>
    <iframe
      :src="frame.src"
      marginheight="0"
      marginwidth="0"
      vspace="0"
      hspace="0"
      scrolling="yes"
      name="styleguideRenderer"
      frameborder="0"
      v-if="activeComponent.relativePath" />
    <div v-else>
      Please choose a component
    </div>
  </div>
</template>

<script>
export default {
  name: 'ComponentRender',
  computed: {
    activeComponent() {
      return this.$store.getters.activeTemplate;
    },
    frame() {
      const previewUrl = './styleguide/';
      return {
        src: previewUrl + this.activeComponent.relativePath,
      };
    },
  },
};
</script>

<style scoped>
div {
  position: relative;
  z-index: 100;
  padding: 20px;
  height: 100vh;
}

iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: calc(100% - 40px);
  height: 100%;
}
</style>
