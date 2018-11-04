<template>
  <aside class="pl-aside">
    <div class="pl-logo">
      <img :src="logoSrc" alt="Craft Gonzo">
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
    <TemplatelistNavigation/>
  </aside>
</template>
<script>
import LogoSvg from '@Images/logo.svg';
import TemplatelistNavigation from '@Components/TemplatelistNavigation';

export default {
  name: 'AppHeader',
  components: { TemplatelistNavigation },
  computed: {
    logoSrc() {
      return window.assetsUrl + LogoSvg;
    },
  },
};
</script>
