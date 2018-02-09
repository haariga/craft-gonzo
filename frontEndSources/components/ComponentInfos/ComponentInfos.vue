<template>
  <div>
    <div class="pl-intro" v-if="infos.title">
      <div class="pl-intro__meta ms-res--1">
        <div class="pl-intro__type">
          <strong>{{ infos.type }}</strong> • Path: {{ infos.path }}
        </div>
        <span class="pl-intro__status wip">{{ infos.status }}</span>
      </div>
      <h1 class="pl-headline--h1  ms-res-5">{{ infos.title }}</h1>
      <div class="pl-intro__description  ms-res-1">
        {{ infos.description }}
      </div>
    </div>
    <hr class="pl-hr" >
  </div>
</template>

<script>
export default {
  name: 'ComponentInfos',
  computed: {
    infos() {
      return this.$store.getters.activeComponent;
    },
  },
};
</script>

<style lang="scss">

</style>
