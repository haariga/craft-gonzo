<template>
  <div id="patternlib">
    <div class="pl-wrapper">
      <AppHeader/>
      <main class="pl-main">
        <MainNavigation/>
        <div class="pl-main__inner">
          <router-view :key="$route.name || $route.params.name" />
        </div>
        <AppFooter/>
      </main>
    </div>
  </div>
  
</template>

<script>
import AppFooter from '@Components/AppFooter';
import MainNavigation from '@Components/MainNavigation';
import AppHeader from '@Components/AppHeader';

export default {
  components: { AppHeader, AppFooter, MainNavigation },
};
</script>
