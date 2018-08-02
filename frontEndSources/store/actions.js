export default {
  setFilelist({ commit }, products) {
    return new Promise((resolve, reject) => {
      commit('SET_FILELIST', products);
      resolve();
    });
  },
  setPluginSettings({ commit }, settings) {
    commit('SET_PLUGIN_SETTINGS', settings);
  },
  setActive({ commit, state }, component) {
    window.history.pushState(
      {},
      component.config.meta.title,
      `?template=${component.config.meta.path}`,
    );
    commit('SET_ACTIVE', component);

    const [activeFolder] = state.filelist
      .filter(item => {
        if (item.children.some(child => child.name === component.name)) {
          return true;
        }
        return false;
      })
      .map(item => item.name);

    commit('SET_OPEN', activeFolder);
    commit('SET_LOADING_STATUS', true);
  },
};
