<template>
  <header class="pl-head">
    <nav class="pl-nav">
      <template v-if="hasIntroPage">
        <router-link :class="{'router-link-exact-active': $route.path.includes('intro')}" to="/pages/intro" @click.native="$store.commit('SET_ACTIVE_FOLDER', '')">
          {{ introPage.label }}
        </router-link>
      </template>
      <router-link :to="componentLink"
                   :class="{'router-link-exact-active': $route.path.includes('component')}"
                   exact
                   @click.native="changeFolder">Components</router-link>
      <router-link v-for="(pageOptions, page) in patternlibPages"
                   :key="pageOptions.label"
                   :to="`/pages/${page}`"
                   :class="{'router-link-exact-active': $route.path.includes(page)}"
                   @click.native="$store.commit('SET_ACTIVE_FOLDER', '')"
      >
        {{ pageOptions.label }}
      </router-link>
    </nav>
  </header>
</template>
<script>
export default {
  name: 'MainNavigation',
  computed: {
    firstComponent() {
      const components = this.$store.state.filelist.items;

      const firstCollection = Object.entries(components).reduce(
        (obj, [component, values], index, source) => {
          if (source[0].indexOf(component) === 0) {
            return values;
          }
          return obj;
        },
        {},
      );

      const folder = firstCollection.name;
      const firstComponent = firstCollection.children.filter(
        (component, index, source) => source.indexOf(component) === 0,
      );

      return {
        folder,
        value: firstComponent[0],
      };
    },
    hasIntroPage() {
      return Object.keys(this.$store.state.pluginSettings.pages).includes('intro');
    },
    introPage() {
      if (!this.hasIntroPage) {
        return null;
      }

      const { pages } = this.$store.state.pluginSettings;
      return Object.entries(pages).reduce((obj, [page, values]) => {
        if (page === 'intro') {
          return values;
        }

        return obj;
      }, {});
    },
    componentLink() {
      return `/component/${this.firstComponent.value.identifier}`;
    },
    patternlibPages() {
      const { pages } = this.$store.state.pluginSettings;
      return Object.entries(pages).reduce((obj, [page, values]) => {
        if (page !== 'intro') {
          obj[page] = values;
        }

        return obj;
      }, {});
    },
  },
  methods: {
    changeFolder() {
      this.$store.commit('SET_ACTIVE_FOLDER', this.firstComponent.folder);
    },
  },
};
</script>
