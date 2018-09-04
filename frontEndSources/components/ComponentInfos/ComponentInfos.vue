<template>
  <div>
    <div v-if="infos.title" class="pl-intro">
      <div class="pl-intro__meta ms-res--1">
        <div class="pl-intro__type">
          <strong>{{ infos.type }}</strong> • Path: {{ infos.path }}
        </div>
        <span :style="{backgroundColor: status.color}"
              class="pl-intro__status wip">
          {{ status.name.toUpperCase() }}
        </span>
      </div>
      <h1 class="pl-headline--h1  ms-res-5">{{ infos.title }}</h1>
      <div class="pl-intro__description  ms-res-1">
        {{ infos.description }}
      </div>
    </div>
    <!--<hr class="pl-hr" >-->
  </div>
</template>

<script>
import { mapGetters } from 'vuex';

export default {
  name: 'ComponentInfos',
  computed: {
    ...mapGetters({
      infos: 'activeInfos',
    }),
    status() {
      return this.$store.getters.compStatus(this.infos.status);
    },
  },
};
</script>
