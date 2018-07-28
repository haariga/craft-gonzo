<template>
  <div class="c-templateSwitcher">
    <div class="c-templateSwitcher__switcher">
      <button :class="{'pl-button--active': active === 'twig'}"
              class="pl-button  pl-button--pill  c-templateSwitcher__button"
              @click="active = 'twig'">Twig</button>
      <button :class="{'pl-button--active': active === 'rendered'}"
              class="pl-button  pl-button--pill  c-templateSwitcher__button"
              @click="active = 'rendered'">HTML</button>
      <button class="pl-button  pl-button--pill  c-templateSwitcher__button">Copy Code</button>
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

<style scoped lang="scss">
.c-templateSwitcher {
  &__switcher {
    display: flex;
    flex-flow: row wrap;
    justify-content: flex-start;
    background-color: c('black', '95');
    background: #0d0d0d;
    padding: 32px;
    padding-bottom: 0;
    margin-bottom: -37px;
    border-radius: 5px;
    margin-bottom: s(-4);

    button:last-of-type {
      margin-left: auto;
      margin-right: 0;
    }
  }
}
</style>
