<template>
  <div id="patternlib">
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
        <MainNavigation/>
        <div class="pl-main__inner">
          <router-view />
        </div>
      
        <div class="pl-main__footer">
          Made with <span>♥</span> by <a href="https://github.com/martinherweg/">Martin Herweg</a> &amp; <a
            href="https://davidhellmann.com">David Hellmann</a>
        </div>
      </main>
    </div>
  </div>
  
</template>

<script>
import MainNavigation from '@Components/MainNavigation';

export default {
  components: { MainNavigation },
};
</script>
