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
    parentStatus: {
      type: String,
      default: '',
    },
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
      let status;
      if (this.activeVariant.status === '') {
        status = this.parentStatus;
      } else {
        // eslint-disable-next-line
        status = this.activeVariant.status;
      }
      return this.$store.getters.compStatus(status);
    },
  },
};
</script>
