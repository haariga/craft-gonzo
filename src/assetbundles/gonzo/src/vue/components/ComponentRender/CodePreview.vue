<template>
  <div class="pl-content__section">
    <div class="pl-content__container">
      <div class="c-templateSwitcher">
        <div class="c-templateSwitcher__switcher">
          <div class="pl-buttonGroup--pill">
            <button v-for="button in buttons" :key="button"
                    class="pl-button pl-button--pill"
                    @click="activeTab = button">
              {{ button }}
            </button>
          </div>
        </div>
        
        <div class="c-templateSwitcher__code">
          <pre v-html="activeRender"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CodePreview',
  components: {},
  props: {
    filesToRender: {
      type: Object,
      default: () => ({}),
    },
  },
  data() {
    return {
      activeTab: 'twig',
      variantRender: '',
    };
  },
  computed: {
    buttons() {
      return ['twig', 'html', ...this.filesToRender.assets.map(asset => asset.type)];
    },
    activeRender() {
      const template = this.filesToRender.templates[0];
      const activeVariant = this.filesToRender.variants[this.$route.query.variant];

      if (this.activeTab === 'twig') {
        return template.content;
      }
      if (this.activeTab === 'html') {
        this.getFileContent(template, activeVariant);
        return this.variantRender;
      }

      const activeAsset = this.filesToRender.assets.find(asset => asset.type === this.activeTab);

      return activeAsset.content;
    },
  },
  watch: {},
  mounted() {},
  created() {},
  methods: {
    getFileContent(template, activeVariant) {
      const formData = new FormData();

      formData.append('file', template.relativePath);
      formData.append('meta', JSON.stringify(activeVariant));

      window.axios.post('patternlib/getfilerender/', formData).then(({ data }) => {
        this.variantRender = data;
        console.log(data);
      });
    },
  },
};
</script>
