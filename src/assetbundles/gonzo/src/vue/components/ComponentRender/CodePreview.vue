<template>
  <div class="pl-content__section">
    <div class="pl-content__container">
      <div class="pl-content__templateSwitcher">
        <div class="pl-content__templateSwitcherSwitcher">
          <h2>Source code</h2>
          <div class="pl-buttonGroup--pill  pl-buttonGroup--margin">
            <button v-for="button in buttons" :key="button"
                    :class="{ 'pl-button--active': activeTab === button }"
                    class="pl-button pl-button--pill"
                    @click="activeTab = button">
              {{ button }}
            </button>
          </div>
        </div>

        <div class="pl-content__templateSwitcherCode">
          <pre class="line-numbers">
            <code ref="prismContainer"
                  :class="prismLang"
                  v-html="activeRender"/>
          </pre>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Prism from 'prismjs';

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
    prismLang() {
      return `language-${this.activeTab}`;
    },
    activeRender() {
      let codeToRender = '';
      const template = this.filesToRender.templates[0];
      const activeVariant = this.filesToRender.variants[this.$route.query.variant];

      if (this.activeTab === 'twig') {
        codeToRender = template.content;
      } else if (this.activeTab === 'html') {
        this.getFileContent(template, activeVariant);
        codeToRender = this.variantRender;
      } else {
        const activeAsset = this.filesToRender.assets.find(asset => asset.type === this.activeTab);
        codeToRender = activeAsset.content;
      }

      return Prism.highlight(codeToRender, Prism.languages[this.activeTab]);
    },
  },
  watch: {
    activeRender() {
      this.$nextTick(() => {
        Prism.highlightAll();
      });
    },
  },
  mounted() {
    this.$nextTick(() => {
      Prism.highlightAll();
    });
  },
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
