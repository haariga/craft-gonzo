import { defineStore } from 'pinia';

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
    setActiveComponent(component: IComponent) {
      this.activeComponent = component;
    },
  },
});
