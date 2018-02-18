<template>
  <nav class="pl-files">
    <h3 class="pl-files__headline  ms-res--1"
        :class="{'pl-files__headline--active': showTemplates}"
        v-if="depth >= 1"
        @click="showTemplatesFn">
      {{ label }}
    </h3>
    <ul class="pl-files__list">
      <filelist
        v-for="node in nodes"
        :nodes="node.children"
        :label="node.name"
        :key="node.name"
        :depth="depth + 1"
        v-if="!node.templates && typeof node === 'object'"
      />
      <Templatelist
        :node="node"
        :depth="depth + 1"
        v-show="showTemplates"
        v-else-if="typeof node === 'object'"/>
    </ul>
  </nav>
</template>

<script>
import Templatelist from 'Modules/Templatelist/Templatelist';
/* eslint-disable */
export default {
  name: 'Filelist',
  props: {
    label: {
      type: String,
      default: 'Label',
    },
    nodes: {
      default: () => {},
    },
    depth: {
      type: Number,
      default: 0,
    },
  },
  components: {
    Templatelist,
  },
  data() {
    return {
      showTemplates: false,
    };
  },
  methods: {
    showTemplatesFn() {
      this.showTemplates = !this.showTemplates;

      if (this.showTemplates) {
        const firstItem = Object.keys(this.nodes)[0];

        this.$store.dispatch('setActive', this.nodes[firstItem]);
      }
    },
  },
};
</script>


<style>
.pl-files__listItem {
  overflow: hidden;
}
</style>
