<template>
  <nav class="pl-files">
    <h3 v-if="depth >= 1"
        :class="{'pl-files__headline--active': showTemplates}"
        class="pl-files__headline  ms-res-0"
        @click="showTemplatesFn(label.toLowerCase())">
      <div class="pl-files__icon">
        <span class="top"/>
        <span class="line  line--01"/>
        <span class="line  line--02"/>
        <span class="line  line--03"/>
        <span class="bottom"/>
      </div>
      {{ formattedLabel }}
    </h3>
    <ul class="pl-files__list">
      <filelist
        v-for="node in nodes"
        v-if="!node.templates && typeof node === 'object'"
        :nodes="node.children"
        :label="node.name"
        :key="node.name"
        :depth="depth + 1"
      />
      <Templatelist
        v-show="showTemplates"
        v-else-if="typeof node === 'object'"
        :node="node"
        :depth="depth + 1"/>
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
  computed: {
    openFolder() {
        return this.$store.state.openFolder;
    },
    showTemplates() {
        return this.openFolder === this.label.toLowerCase();
    },
    formattedLabel() {
        let label = this.label;
        if (label.charAt(0) === '_') {
          label = label.substr(1);
        }
        return label
    },
  },
  methods: {
    showTemplatesFn(name) {
      this.$store.commit('SET_OPEN', name);

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
