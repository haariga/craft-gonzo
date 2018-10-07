<template>
  <nav class="pl-files">
    <h3 v-if="depth >= 1" class="pl-files__headline  ms-res-0" @click="setActiveFolder(label)">
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
      <filelist v-for="node in nodes"
                v-if="!node.templates && typeof node ==='object'"
                :key="node.name"
                :depth="depth + 1"
                :nodes="node.children"
                :label="node.name" />
      <Templatelist
        v-else-if="typeof node === 'object' && showTemplates"
        :node="node"
        :depth="depth + 1"
      />
    </ul>
  </nav>
</template>

<script>
import Templatelist from './Templatelist';

export default {
  name: 'Filelist',
  components: { Templatelist },
  props: {
    label: {
      type: String,
      default: 'Label',
    },
    nodes: {
      type: Array,
      default: () => [],
    },
    depth: {
      type: Number,
      default: 0,
    },
  },
  computed: {
    filelist() {
      return this.$store.state.filelist.items;
    },
    activeFolder() {
      return this.$store.state.filelist.activeFolder;
    },
    formattedLabel() {
      const { label } = this;
      return label.charAt(0) === '_' ? label.substr(1) : label;
    },
    showTemplates() {
      return this.activeFolder === this.label.toLowerCase();
    },
  },
  watch: {},
  mounted() {
    // setting active component on reload
    if (this.$route.params.name.includes(this.label)) {
      this.$store.commit('SET_ACTIVE_FOLDER', this.label);
    }
  },
  created() {},
  methods: {
    setActiveFolder(folder) {
      // setting the active folder in the store
      this.$store.commit('SET_ACTIVE_FOLDER', folder);
      // search for first component of active folder
      const firstItem = this.filelist[folder].children[0];
      // push router to this component
      this.$router.push(`/component/${firstItem.identifier}`);
    },
  },
};
</script>
