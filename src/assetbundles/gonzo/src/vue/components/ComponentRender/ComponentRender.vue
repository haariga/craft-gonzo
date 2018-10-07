<template>
  <div class="pl-content">
    <div class="pl-content__section">
      <Variants v-if="Object.keys(render.variants).length > 1"
                :variants="render.variants"
                :template="render.templates[0]"
                @variantSelected="activeVariant = $event"
      />
      <i-frame-area :frame-src="frameSrc"/>
    </div>
  </div>
</template>

<script>
import IFrameArea from 'Modules/ComponentRender/iFrame-Area';
import Variants from 'Modules/ComponentRender/Variants';

export default {
  name: 'ComponentRender',
  components: { IFrameArea, Variants },
  props: {
    render: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      activeVariant: '',
    };
  },
  computed: {
    mqButtons() {
      return this.$store.state.pluginSettings.mqButtons;
    },
    frameSrc() {
      // TODO: make configurable
      const previewUrl = '/patternlib';

      if (Object.keys(this.render.variants).length > 1) {
        return `${previewUrl}${this.render.templates[0].relativePath}/variant/${
          this.activeVariant
        }`;
      }

      const [variantName] = Object.keys(this.render.variants);

      return `${previewUrl}${this.render.templates[0].relativePath}/variant/${variantName}`;
    },
  },
  watch: {},
  mounted() {},
  created() {},
  methods: {},
};
</script>
