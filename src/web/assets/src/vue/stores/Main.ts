import { defineStore } from 'pinia';
import type { IComponent } from '@/vue/components/Sidebar/SidebarComponent.vue';

export interface ISectionComponent {
  configs: IComponent[];
  title: string;
}

interface ISection {
  children: ISectionComponent[];
  config: {
    title: string;
  };
}

interface IState {
  components: {
    [key: string]: ISection;
  };
}

export const useMainStore = defineStore('main', {
  state: (): IState => ({ components: {} }),
  actions: {
    addComponents(components) {
      this.components = components;
    },
  },
});
