<template>
  <div v-if="fileContent" class="pl-content__asset">
    <h2 v-if="showHeadline" class="pl-headline--h5">Code: {{ file.extension ? file.extension.toUpperCase() : '' }}</h2>
    <div class="pl-content__container  pl-content__container--code">
      <pre class="line-numbers">
        <code
        ref="prismContainer"
        :class="setLang"
        v-html="highlightedCode" />
      </pre>
    </div>
  </div>
</template>

<script>
import Prism from '../../plugins/prism'; // eslint-disable-line
// import '../../plugins/prism-normalize-whitespace';  // eslint-disable-line

export default {
  name: 'CodeContent',
  props: {
    file: {
      type: [Object, Array],
      default: () => {},
    },
    getTemplate: {
      type: Boolean,
      default: true,
    },
    showHeadline: {
      type: Boolean,
      default: true,
    },
    prismLanguage: {
      type: String,
      default: 'html',
    },
  },
  data() {
    return {
      fileData: {},
      prismLang: this.prismLanguage || this.file.extension, // naming ne
    };
  },
  computed: {
    highlightedCode() {
      if (this.fileContent.length) {
        return Prism.highlight(this.fileContent, Prism.languages[this.prismLang]);
      }
      return Prism.highlight('<span>Loading Code...</span>', Prism.languages[this.prismLang]);
    },
    setLang() {
      let lang = this.prismLang;

      if (this.file.extension === 'html') {
        lang = 'twig';
      }

      return `language-${lang}`;
    },
    fileContent() {
      if (this.file && this.file.code) {
        return this.file.code;
      }
      if (this.fileData) {
        return this.fileData;
      }

      return '';
    },
  },
  watch: {
    file: 'getFileContent',
    highlightedCode(newValue) {
      // eslint-disable consistent-return
      if (!newValue.length > 0) {
        return;
      }

      this.$nextTick(() => {
        Prism.highlightAll();
      });
    },
  },
  created() {
    if (this.getTemplate) {
      this.getFileContent();
    }
  },
  methods: {
    getFileContent() {
      if (!this.file && !this.file.relativePath) return;
      window.axios.get(`patternlib/getfilecontent/${this.file.relativePath}`).then(({ data }) => {
        this.fileData = data;
      });
    },
  },
};
</script>
/* eslint-enable */
