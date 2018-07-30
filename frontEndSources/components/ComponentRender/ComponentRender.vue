<template>
  <div class="pl-content">
    <div class="pl-content__section">
      <div class="pl-content__container  pl-content__container--iframeActions">
        <div class="pl-buttonGroup  pl-buttonGroup--pill">
          <button v-for="width in mqButtons"
                  :class="{'pl-button--active': activeWidth === width}"
                  :key="width"
                  class="pl-button pl-button--pill"
                  @click="iFrameWidth(width)"
                  v-text="`${width}`"/>

          <a :href="frame.src" class="pl-button pl-button--newWindow" target="_blank">Open in new tab</a>
        </div>
      </div>
      <div :class="{'pl-content__container--loaded': iFrame.loaded}" class="pl-content__container  pl-content__container--iframe">
        <transition name="fade">
          <iframe v-show="activeTemplate.relativePath && iFrame.loaded"
                  ref="iframe"
                  :style="{ 'max-width': iFrame.width }"
                  :src="frame.src"
                  :height="iFrame.height"
                  marginheight="0"
                  marginwidth="0"
                  vspace="0"
                  hspace="0"
                  scrolling="yes"
                  name="patternlibRenderer"
                  frameborder="0"
                  @load="iFrameSize"
          />
        </transition>
        <transition name="fade">
          <div v-show="!activeTemplate.relativePath && iFrame.loaded">
            Please choose a component
          </div>
        </transition>
      </div>
    </div>
    
    Varianten:
  
    <select id="variants" v-model="selectedVariant" name="variants"
            @change="switchVariant($event)">
      <!-- eslint-disable vue/no-unused-vars -->
      <option v-for="(values, variant) in activeVariants" :value="variant" :key="variant"
              v-text="values.title"/>
    </select>
    
    <hr class="pl-hr">
    
    <TemplateSwitcher :files="templateSwitcher" />

    <hr class="pl-hr">

    <div v-if="activeComponentAssets.length" class="pl-content__section">
      <code-content v-for="asset in activeComponentAssets"
                    :file="asset"
                    :prism-language="asset.extension"
                    :key="asset.relativePath"/>
    </div>
  </div>
</template>

<script>
import TemplateSwitcher from '../TemplateSwitcher/TemplateSwitcher';
import CodeContent from '../CodeContent/CodeContent';

export default {
  name: 'ComponentRender',
  components: { TemplateSwitcher, CodeContent },
  data() {
    return {
      selectedVariant: '',
      buttonActive: false,
      sidebar: false,
      activeWidth: 'none',
      iFrame: {
        loaded: false,
        height: 0,
        width: '100%',
      },
      scssContent: '',
      jsContent: '',
    };
  },
  computed: {
    templateSwitcher() {
      return [
        {
          type: 'twig',
          getTemplate: true,
          file: this.activeTemplate,
          prism: 'twig',
        },
        {
          type: 'rendered',
          getTemplate: false,
          file: this.activeComponentRender,
          prism: 'html',
        },
      ];
    },
    activeTemplate() {
      return this.$store.getters.activeTemplate;
    },
    activeComponent() {
      return this.$store.getters.activeComponent;
    },
    activeComponentAssets() {
      return this.$store.getters.activeComponentAssets;
    },
    activeComponentRender() {
      return this.$store.getters.activeComponentRender;
    },
    activeVariants() {
      return this.$store.getters.activeComponentVariants;
    },
    activeVariant() {
      return this.activeVariants[this.selectedVariant];
    },
    mqButtons() {
      return this.$store.getters.mqButtons;
    },
    frame() {
      const previewUrl = './patternlib';
      return {
        src: `${previewUrl}${this.activeTemplate.relativePath}/variant/${this.selectedVariant}`,
      };
    },
  },
  watch: {
    activeVariants(newValue) {
      // eslint-disable-next-line
      this.selectedVariant = Object.keys(newValue)[0];
    },
  },
  methods: {
    toggleClass() {
      this.buttonActive = !this.buttonActive;
    },
    switchVariant(e) {
      const formData = new FormData();

      console.log(this.activeVariants[e.target.value]);

      formData.append('file', this.activeTemplate.relativePath);
      formData.append('meta', JSON.stringify(this.activeVariants[e.target.value]));

      window.axios.post('patternlib/getfilerender/', formData).then(({ data }) => {
        this.$store.commit('SET_TEMPLATERENDER', data);
      });
    },
    iFrameWidth(width) {
      let widthNumber = width.replace('px', '');
      widthNumber = Number.parseInt(widthNumber, 10);
      this.activeWidth = width;
      if (width.includes('px')) {
        this.$set(this.iFrame, 'width', `${widthNumber + 64}px`);
      } else {
        this.$set(this.iFrame, 'width', 'none');
      }
      this.$nextTick(() => this.iFrameSize());
    },
    iFrameSize() {
      const iFrame = this.$refs.iframe;
      if (iFrame) {
        this.iFrame.loaded = true;
        this.$nextTick(() => {
          this.iFrame.height = `${iFrame.contentWindow.document.body.scrollHeight + 120}px`;
        });
      }
    },
  },
};
</script>

<style lang="scss">
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}
</style>
