<template>
  <div :class="`${cn}`">
    <div :class="`${cn}__left`">
      <div :class="`${cn}__label  ${status.name}`" :style="{backgroundColor: status.color}">
        {{ status.name }}
      </div>
    </div>
    <div :class="`${cn}__right`">
      <p>
        {{ activeVariant.description }}
      </p>
    </div>
  </div>
</template>

<script>
export default {
  name: 'VariantMeta',
  components: {},
  props: {
    activeVariant: {
      type: Object,
      default() {
        return {};
      },
    },
  },
  data() {
    return {
      cn: 'pl-variantMeta',
    };
  },
  computed: {
    status() {
      return this.$store.getters.compStatus(this.activeVariant.status);
    },
  },
};
</script>
