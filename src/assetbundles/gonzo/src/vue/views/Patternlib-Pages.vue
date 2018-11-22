<template>
  <div class="pl-content__section">
    <div class="pl-content__container pl-content__container--iFrameActions">
      <div class="pl-buttonGroup pl-buttonGroup--pill">
        <button v-for="width in mqButtons"
                :key="width"
                :class="{ 'pl-button--active': activeWidth === width }"
                class="pl-button pl-button--pill"
                @click="iFrameWidth(width)"
                v-text="width" />

        <a :href="frameSrc" target="_blank" class="pl-button pl-button--newWindow">Open in new tab</a>
      </div>
    </div>

    <div :class="{ 'pl-content__container--loaded': iFrame.loaded }"
         class="pl-content__container pl-content__container--iframe  pl-content__container--iframePages">
      <iFrame ref="iFrame"
              :src="frameSrc"
              :class="{ 'iFrameLoaded': iFrame.loaded }"
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
  </div>
</template>

<script>
export default {
  name: 'PatternlibPages',
  metaInfo() {
    return {
      title: `patternlib - ${this.$route.params.name}`,
      bodyAttrs: {
        class: 'page',
      },
    };
  },
  data() {
    return {
      activeWidth: '100%',
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
    mqButtons() {
      return this.$store.state.pluginSettings.mqButtons;
    },
  },
  mounted() {
    if (!this.$route.query.frameSize) {
      this.setFrameSizeQuery('100%');
    } else {
      this.activeWidth = this.$route.query.frameSize;
      this.iFrame.width = this.$route.query.frameSize;
    }
  },
  methods: {
    setFrameSizeQuery(size) {
      this.$router.push({
        query: { ...this.$route.query, frameSize: size },
      });
    },
    iFrameWidth(width) {
      let widthNumber = width
        .replace('px', '')
        .replace('%', '')
        .replace('vw', '');
      widthNumber = Number.parseInt(widthNumber, 10);
      this.activeWidth = width;
      this.setFrameSizeQuery(width);
      if (width.includes('px')) {
        this.$set(this.iFrame, 'width', `${widthNumber}px`);
      } else if (width.includes('%')) {
        this.$set(this.iFrame, 'width', `${widthNumber}%`);
      } else if (width.includes('vw')) {
        this.$set(this.iFrame, 'width', `${widthNumber}vw`);
      } else {
        this.$set(this.iFrame, 'width', 'none');
      }
      this.$nextTick(() => this.iFrameSize());
    },
    iFrameSize() {
      const { iFrame } = this.$refs;
      this.iFrame.loaded = true;
      if (iFrame) {
        this.$nextTick(() => {
          setTimeout(() => {
            this.iFrame.height = `${iFrame.contentWindow.document.body.scrollHeight + 120}px`;
          }, 250);
        });
      }
    },
  },
};
</script>
