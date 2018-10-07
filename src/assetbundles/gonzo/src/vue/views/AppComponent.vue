<template>
  <div class="pl-component">
    Das ist eine Komponente mit id von {{ $route.params.name }}
    <ComponentInfos :infos="infos" />
  </div>
</template>

<script>
import ComponentInfos from '@Components/ComponentInfos';

export default {
  name: 'AppComponent',
  components: { ComponentInfos },
  data() {
    return {};
  },
  computed: {
    componentData() {
      const { filelist: { items } = {} } = this.$store.state;
      const { name } = this.$route.params;
      const splitName = name.split('.');
      return items[splitName[0]].children.find(
        item => item.name === splitName[splitName.length - 1],
      );
    },
    infos() {
      const { meta } = this.componentData.config;
      return meta;
    },
  },
  watch: {},
  mounted() {},
  created() {},
  methods: {},
};
</script>
