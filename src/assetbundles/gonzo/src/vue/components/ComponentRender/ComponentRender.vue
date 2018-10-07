<template>
  <div class="pl-content">
    <div class="pl-content__section">
      <Variants v-if="Object.keys(render.variants).length > 1" :variants="render.variants" :template="render.templates[0]"/>
    </div>
  </div>
</template>

<script>
import Variants from 'Modules/ComponentRender/Variants';

export default {
  name: 'ComponentRender',
  components: { Variants },
  props: {
    render: {
      type: Object,
      default: () => {},
    },
  },
  data() {
    return {};
  },
  computed: {
    mqButtons() {
      return this.$store.state.pluginSettings.mqButtons;
    },
  },
  watch: {},
  mounted() {},
  created() {},
  methods: {},
};
</script>
