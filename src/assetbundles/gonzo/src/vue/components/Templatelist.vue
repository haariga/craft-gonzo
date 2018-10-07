<template>
  <li class="pl-files__listItem">
    <router-link :to="`/component/${node.identifier}`"
                 class="pl-files__listItemLink ms-res--1"
                 exact-active-class="pl-files__listItemLink--active">
      {{ node.config.meta.title || node.config.title }}
    </router-link>
  </li>
</template>

<script>
export default {
  name: 'Templatelist',
  components: {},
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
};
</script>
