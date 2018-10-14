<template>
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
    <TemplatelistNavigation/>
  </aside>
</template>
<script>
import TemplatelistNavigation from '@Components/TemplatelistNavigation';

export default {
  name: 'AppHeader',
  components: { TemplatelistNavigation },
};
</script>
