<template>
  <div>
    <iFrame ref="iFrame"
            :src="frameSrc"
            :style="frameSyle"
            marginheight="0"
            marginwidth="0"
            vspace="0"
            hspace="0"
            scrolling="yes"
            name="patternlibRenderer"
            frameborder="0"
            @load="iFrameSize"
    />
  </div>
</template>

<script>
export default {
  name: 'PatternlibPages',
  data() {
    return {
      iFrame: {
        loaded: false,
        height: 0,
        width: '100%',
      },
    };
  },
  computed: {
    frameSyle() {
      return {
        width: this.iFrame.width,
        height: this.iFrame.height,
      };
    },
    frameSrc() {
      const previewUrl = '/patternlib';
      return `${previewUrl}/pages-render/${this.$route.params.name}`;
    },
  },
  methods: {
    iFrameSize() {
      const { iFrame } = this.$refs;
      this.iFrame.loaded = true;
      if (iFrame) {
        this.$nextTick(() => {
          setTimeout(() => {
            this.iFrame.height = `${iFrame.contentWindow.document.body.scrollHeight}px`;
          }, 250);
        });
      }
    },
  },
};
</script>
