<template>
  <div class="c-templateSwitcher">
    <div class="c-templateSwitcher__switcher">
      <button>Copy Code</button>
      <div>
        <button @click="active = 'twig'">Twig</button>
        <button @click="active = 'rendered'">Rendered Html</button>
      </div>
    </div>
    
    <div class="c-templateSwitcher__code">
      <code-content v-for="file in files" v-show="active === file.type"
                    :key="file.type"
                    :file="file.file" :get-template="file.getTemplate"
                    :show-headline="false"
      />
    </div>
  </div>
</template>

<script>
import CodeContent from 'Modules/CodeContent/CodeContent';

export default {
  name: 'TemplateSwitcher',
  components: { CodeContent },
  props: {
    files: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      active: 'twig',
    };
  },
  computed: {},
  watch: {},
  mounted() {},
  created() {},
  methods: {},
};
</script>
