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

        <a :href="newTabLink" target="_blank" class="pl-button pl-button--newWindow">Open in new tab</a>
      </div>
    </div>

    <div :class="{ 'pl-content__container--loaded': iFrame.loaded }"
         class="pl-content__container pl-content__container--iframe">
      <iframe ref="iFrame"
              :src="frameSrc"
              :class="{ 'iFrameLoaded': iFrame.loaded }"
              :style="{'width': iFrame.width, 'height': iFrame.height, 'max-width': iFrame.maxWidth }"
              :height="parseInt( iFrame.height, 10)"
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
  name: 'IFrameArea',
  components: {},
  props: {
    frameSrc: {
      type: String,
      default: '',
    },
  },
  data() {
    return {
      activeWidth: '100vw',
      iFrame: {
        loaded: false,
        height: '240px',
        width: '100vw',
        maxWidth: '100%',
      },
    };
  },
  computed: {
    mqButtons() {
      return this.$store.state.pluginSettings.mqButtons;
    },
    newTabLink() {
      return `${this.frameSrc}?fullSize${
        this.$route.params.name.includes('views') ? '&isView' : ''
      }`;
    },
  },
  mounted() {
    if (!this.$route.query.frameSize) {
      this.setFrameSizeQuery('100vw');
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
        this.$set(this.iFrame, 'width', `${widthNumber + 16}px`);
        this.$set(this.iFrame, 'maxWidth', 'none');
      } else if (width.includes('%')) {
        this.$set(this.iFrame, 'width', `${widthNumber}%`);
        this.$set(this.iFrame, 'maxWidth', '100%');
      } else if (width.includes('vw')) {
        this.$set(this.iFrame, 'width', `${widthNumber}vw`);
        this.$set(this.iFrame, 'maxWidth', '100%');
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
