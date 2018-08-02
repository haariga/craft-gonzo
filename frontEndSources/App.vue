<template>
  <div class="pl-wrapper">
    <aside class="pl-aside">
      <div class="pl-logo">
        Gonzo <span>Pattern Library</span>
      </div>
      <input id="mainNav"
             class="pl-mainNavCheckBox"
             type="checkbox"
             name="mainNav">
      <label class="pl-mainNavTrigger" for="mainNav">
        <span/>
        <span/>
        <span/>
      </label>
      <div v-for="item in filelist" v-show="sidebar" :key="item.name">
        <Filelist :depth="1" :label="item.name" :nodes="item.children"/>
      </div>
    </aside>
    
    
    <main class="pl-main">
      <header class="pl-head">
        <nav class="pl-nav">
          Home
        </nav>
      </header>
      <div class="pl-main__inner">
        <PreviewArea v-if="applicationLoaded"/>
        <div v-else>
          Loading Component.
        </div>
      </div>
      
      <div class="pl-main__footer">
        Made with <span>♥</span> by <a href="https://github.com/martinherweg/">Martin Herweg</a> &amp; <a
          href="https://davidhellmann.com">David Hellmann</a>
      </div>
    </main>
  </div>
</template>


<script>
import Filelist from 'Modules/Filelist/Filelist';
import PreviewArea from 'Modules/PreviewArea/PreviewArea';
import { flatten } from 'lodash';
import { getParameterByName } from './helpers';

export default {
  name: 'Patternlib',
  components: {
    Filelist,
    PreviewArea,
  },
  data() {
    return {
      sidebar: true,
    };
  },
  computed: {
    applicationLoaded() {
      return this.$store.state.applicationLoaded;
    },
    filelist() {
      return this.$store.getters.filelist;
    },
  },
  mounted() {
    this.$store.dispatch('setPluginSettings', window.pluginSettings);

    this.$store.dispatch('setFilelist', window.filelist).then(() => {
      const templateParameter = getParameterByName('template');
      if (templateParameter) {
        const flattendFilelist = flatten(this.filelist.map(item => item.children));
        const activeComponent = flattendFilelist.find(
          component => component.config.meta.path === templateParameter,
        );
        this.$store.dispatch('setActive', activeComponent);
      }
    });
  },
};
</script>
