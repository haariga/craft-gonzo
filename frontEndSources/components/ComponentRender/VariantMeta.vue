<template>
  <div :class="`${cn}`">
    <div :class="`${cn}__left`">
      <div :class="`${cn}__label  ${variantStatus.name}`" :style="{backgroundColor: variantStatus.color}">
        {{ variantStatus.name }}
      </div>
    </div>
    <div :class="`${cn}__right`">
      <p>
        {{ variantData.description }}

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
    status: {
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
    variantData() {
      return this.activeVariant;
    },
    variantStatus() {
      return this.status;
    },
  },
};
</script>
