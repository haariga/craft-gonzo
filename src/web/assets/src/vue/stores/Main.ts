import { defineStore } from 'pinia';

export const useMainStore = defineStore('main', {
  state: () => ({ components: {} }),
  actions: {
    addComponents(components) {
      this.components = components;
    },
  },
});
