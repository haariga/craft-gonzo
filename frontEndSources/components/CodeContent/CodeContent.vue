<template>
  <div class="pl-content__asset" v-if="file">
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
  },
  data() {
    return {
      fileContent: '',
    };
  },
  mounted() {
    this.getFileContent();
  },
  methods: {
    async getFileContent() {
      if (!this.file.relativePath) return;
      const { data } = await window.axios.get(
        `patternlib/getfilecontent/${this.file.relativePath}`,
      );
      this.fileContent = data;
    },
  },
};
</script>
