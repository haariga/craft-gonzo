export default {
  filelist(state) {
    return state.filelist;
  },
  activeComponent(state) {
    return state.activeComponent.config ? state.activeComponent.config : {};
  },
  activeTemplate(state) {
    return state.activeComponent.templates ? state.activeComponent.templates[0] : {};
  }
};
