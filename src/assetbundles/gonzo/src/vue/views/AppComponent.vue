<template>
  <div class="pl-component">
    <ComponentInfos :infos="infos" />
    <ComponentRender :render="render"/>
  </div>
</template>

<script>
import ComponentInfos from '@Components/ComponentInfos';
import ComponentRender from '@Components/ComponentRender/ComponentRender';

export default {
  name: 'AppComponent',
  components: { ComponentRender, ComponentInfos },
  metaInfo() {
    return {
      title: `patternlib - ${this.componentData.config.type}.${this.componentData.config.title}`,
      bodyAttrs: {
        class: 'component',
      },
    };
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
    render() {
      const { variants } = this.componentData.config;
      const { assets, templates, templateRender } = this.componentData;

      return {
        assets,
        templates,
        templateRender: templateRender[0],
        variants,
      };
    },
  },
};
</script>
