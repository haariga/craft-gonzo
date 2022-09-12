import { defineStore } from 'pinia';
import type { IComponent } from '@/vue/@types/Component';

interface IState {
  activeComponent: IComponent;
}

export const useActiveComponentStore = defineStore('activeComponent', {
  state: (): IState => {
    return {
      activeComponent: {
        config: {
          title: '',
          slug: '',
        },
      },
    };
  },
  getters: {
    title(state): string {
      return state.activeComponent.config.title;
    },
    slug(state): string {
      return state.activeComponent.config.slug;
    },
  },
  actions: {
    setActiveComponent(component: IComponent) {
      this.activeComponent = component;
    },
  },
});
