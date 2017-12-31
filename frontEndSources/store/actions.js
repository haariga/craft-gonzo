export default {
  setFilelist({ commit }, products) {
    commit('SET_FILELIST', products);
  },
  setActive({ commit }, component) {
    commit('SET_ACTIVE', component);
  }
};
