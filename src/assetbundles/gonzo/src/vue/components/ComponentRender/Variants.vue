<template>
  <div class="pl-content__section">
    <div class="pl-content__examples" >
      <div class="pl-content__examplesText">
        Variants:
      </div>
      <select id="variants"
              v-model="selectedVariant"
              class="pl-content__examplesDropdown"
              name="variants"
              @change="switchVariant($event)">
        <!-- eslint-disable vue/no-unused-vars -->
        <option v-for="(values, variant) in variants"
                :value="variant"
                :key="variant"
                v-text="values.title"/>
      </select>
      <div class="pl-content__examplesArrow" />
    </div>
    <VariantMeta :active-variant="activeVariant" />
  </div>
</template>

<script>
import pretty from 'pretty';
import VariantMeta from '@Components/ComponentRender/VariantMeta';

export default {
  name: 'Variants',
  components: { VariantMeta },
  props: {
    variants: {
      type: Object,
      default: () => {},
    },
    template: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {
      selectedVariant: '',
      templateRender: '',
    };
  },
  computed: {
    activeVariant() {
      return this.variants[this.selectedVariant];
    },
  },
  watch: {},
  created() {
    [this.selectedVariant] = Object.keys(this.variants);
  },
  methods: {
    getRenderedFile(formData) {
      window.axios.post('/patternlib/getfilerender/', formData).then(({ data }) => {
        this.templateRender = pretty(data, { ocd: true });
      });
    },
    switchVariant(e) {
      const formData = new FormData();

      formData.append('file', this.template.relativePath);
      formData.append('meta', JSON.stringify(this.variants[e.target.value]));

      this.getRenderedFile(formData);
    },
  },
};
</script>
