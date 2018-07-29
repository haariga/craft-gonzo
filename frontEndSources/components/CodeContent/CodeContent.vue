<template>
  <div v-if="fileContent" class="pl-content__asset">
    <h2 v-if="showHeadline" class="pl-headline--h5">Code: {{ file.extension ? file.extension.toUpperCase() : '' }}</h2>
    <div class="pl-content__container  pl-content__container--code">
      <pre :class="setLang" class="line-numbers">
        <code :class="setLang" class="line-numbers">{{ fileContent }}</code>
      </pre>
    </div>
  </div>
</template>

<script>
import '../../plugins/prism'; // eslint-disable-line

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
  },
  data() {
    return {
      fileData: {},
    };
  },
  computed: {
    setLang() {
      let lang = this.file.extension;
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
