<template>
  <div class="pl-wrapper">
    <aside class="pl-aside">
      <div class="pl-logo">
        Gonzo <span>Pattern Library</span>
      </div>
      <input class="pl-mainNavCheckBox" type="checkbox" name="mainNav"
             id="mainNav">
      <label class="pl-mainNavTrigger" for="mainNav">
        <span/>
        <span/>
        <span/>
      </label>
      <div v-show="sidebar" v-for="item in filelist" :key="item.name">
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
        <PreviewArea/>
      </div>
      
      <div class="pl-main__footer">
        Made with <span>♥</span> by <a href="https://github.com/martinherweg/">Martin Herweg</a> &amp; <a
        href="https://davidhellmann.com">David Hellmann</a>
      </div>
    </main>
  </div>
</template>


<script>
/* eslint-disable */
import Filelist from 'Modules/Filelist/Filelist';
import PreviewArea from 'Modules/PreviewArea/PreviewArea';
import { find } from 'object-deep-search';
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
    filelist() {
      return this.$store.getters.filelist;
    },
  },
  mounted() {
    this.$store.dispatch('setPluginSettings', window.pluginSettings);

    this.$store.dispatch('setFilelist', window.filelist).then(() => {});
  },
};
</script>

<style lang="scss">

</style>
