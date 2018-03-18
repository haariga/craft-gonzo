<template>
  <div v-if="fileContent" class="pl-content__asset">
    <h2 class="pl-headline--h5">Code: {{ file.extension ? file.extension.toUpperCase() : '' }}</h2>
    <div class="pl-content__container  pl-content__container--code">
      <pre><code v-text="fileContent"/></pre>
    </div>
  </div>
</template>

<script>
export default {
  name: 'CodeContent',
  props: {
    file: {
      type: Object,
      default: () => {},
    },
    getTemplate: {
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
