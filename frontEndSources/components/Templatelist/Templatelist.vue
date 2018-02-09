<template>
  <li class="pl-files__listItem">
    <a href="#" class="ms-res--1" @click.prevent="selectActiveModule(node)">
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
