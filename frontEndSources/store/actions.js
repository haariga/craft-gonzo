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
  setActive({ commit }, component) {
    window.history.pushState(
      {},
      component.config.meta.title,
      `?template=${component.config.meta.path}`,
    );
    commit('SET_ACTIVE', component);
    commit('SET_LOADING_STATUS', true);
  },
};
