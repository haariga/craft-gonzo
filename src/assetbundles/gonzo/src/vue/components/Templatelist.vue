<template>
  <li class="pl-files__listItem">
    <router-link :to="`/component/${node.identifier}`"
                 class="pl-files__listItemLink ms-res--1"
                 active-class="pl-files__listItemLink--active">
      {{ config.title }} <span :title="statusColor.name || ''" :style="statusStyle" class="pl-files__listItemStatus"/>
    </router-link>
  </li>
</template>

<script>
export default {
  name: 'Templatelist',
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
    pluginSettings() {
      return this.$store.state.pluginSettings;
    },
    config() {
      return this.node.config.meta;
    },
    statusColor() {
      if (!this.pluginSettings || !this.config.status) {
        return '';
      }

      const statusColors = this.pluginSettings.compStatus;
      const componentStatus = statusColors.find(color => color.name === this.config.status);
      return componentStatus;
    },
    statusStyle() {
      return {
        backgroundColor: this.statusColor.color || 'transparent',
      };
    },
  },
};
</script>
