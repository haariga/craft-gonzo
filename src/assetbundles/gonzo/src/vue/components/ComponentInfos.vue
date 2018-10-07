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
    <hr class="pl-hr" >
  </div>
</template>

<script>
export default {
  name: 'ComponentInfos',
  props: {
    infos: {
      type: Object,
      default: () => {},
    },
  },
  computed: {
    status() {
      const { pluginSettings } = this.$store.state;
      if (!pluginSettings) {
        return {};
      }
      // eslint-disable-next-line
      const matchedStatus =
        pluginSettings.compStatus.find(
          status => status.name.toLowerCase() === this.infos.status.toLowerCase(),
        ) || 'wip';
      return matchedStatus;
    },
  },
};
</script>
