import { defineStore } from 'pinia';
import type { IComponent } from '@/vue/components/Sidebar/SidebarComponent.vue';

interface IState {
  activeVariant: string;
  activeComponent: IComponent;
}

export const useActiveComponentStore = defineStore('activeComponent', {
  state: (): IState => {
    return {
      activeVariant: 'Default',
      activeComponent: {
        config: {
          title: '',
          slug: '',
        },
        files: {
          twig: {
            path: '',
            size: 0,
          },
          config: {},
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
    files(state): object {
      return state.activeComponent.files;
    },
  },
  actions: {
    setActiveVariant(variant: string) {
      this.activeVariant = variant;
    },
    setActiveComponent(component: IComponent) {
      this.activeComponent = component;
    },
  },
});
