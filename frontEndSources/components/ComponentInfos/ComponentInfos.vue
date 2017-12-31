<template>
  <div
    class="component_infos"
    v-if="infos.title">
    <div class="component_infos__header">
      <h1>{{ infos.title }}</h1>
      <small class="component_infos__status">{{ infos.status }}</small>
    </div>
    <div class="component_infos__body">
      {{ infos.description }}
    </div>
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

<style scoped>
.component_infos {
  padding: 20px;
  background-color: #313443;
  color: #fff;
}

.component_infos__header {
  display: grid;
  grid-template-columns: 1fr 60px;
}

h1 {
  margin-bottom: 10px;
}

.component_infos__body {
  margin-bottom: 10px;
}

.component_infos__status {
  align-self: flex-start;
  background: #000;
  border-radius: 10px;
  padding: 5px 10px;
  text-align: center;
}
</style>

