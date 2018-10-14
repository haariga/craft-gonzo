<template>
  <div class="pl-content">
    <div class="pl-content__component">
      <Variants v-if="Object.keys(render.variants).length > 1"
                :variants="render.variants"
                :template="render.templates[0]"
                @variantSelected="changeVariant($event)"
      />
      <i-frame-area :frame-src="frameSrc"/>
      <code-preview />
    </div>
  </div>
</template>

<script>
import CodePreview from 'Modules/ComponentRender/CodePreview';
import IFrameArea from 'Modules/ComponentRender/iFrame-Area';
import Variants from 'Modules/ComponentRender/Variants';

export default {
  name: 'ComponentRender',
  components: { CodePreview, IFrameArea, Variants },
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
      return `${previewUrl}${this.render.templates[0].relativePath}/variant/${this.activeVariant}`;
    },
  },
  watch: {},
  created() {
    if (Object.keys(this.render.variants).length === 1) {
      const [variantName] = Object.keys(this.render.variants);
      this.activeVariant = variantName;
      this.addVariantQueryString(variantName);
    }

    if (this.$route.query.variant) {
      this.activeVariant = this.$route.query.variant;
    }
  },
  methods: {
    changeVariant(variant) {
      this.activeVariant = variant;
      this.addVariantQueryString(variant);
    },
    addVariantQueryString(string) {
      this.$router.push({ query: { variant: string } });
    },
  },
};
</script>
