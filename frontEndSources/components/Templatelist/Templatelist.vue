<template>
  <li class="pl-files__listItem" v-if="node !== 'undefined' && node.config !== 'undefined'">
    <a href="#"
       class="pl-files__listItemLink  ms-res--1"
       :class="classObject"
       @click.prevent="selectActiveModule(node)">
      {{ node.config.title }}
    </a>
  </li>
</template>


<script>
export default {
  name: 'TemplateList',
  props: {
    node: {
      type: Object,
      default: () => {},
    },

    depth: {
      type: Number,
      default: 0,
    },
  },
  computed: {
    activeComponent() {
      return this.$store.getters.activeComponent;
    },
    classObject() {
      return {
        'pl-files__listItemLink--active': this.node.config.title === this.activeComponent.title,
      };
    },
    indent() {
      return {
        transform: `translateX(${this.depth * 10}px)`,
      };
    },
  },
  methods: {
    selectActiveModule(module) {
      this.$store.dispatch('setActive', module);
    },
  },
};
</script>

<style scoped>
button {
  font: inherit;
  border: 0;
  background: transparent;
}
</style>
