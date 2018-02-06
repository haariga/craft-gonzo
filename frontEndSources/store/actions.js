export default {
  setFilelist({ commit }, products) {
    commit('SET_FILELIST', products);
  },
  setActive({ commit }, component) {
    localStorage.setItem('activeComponent', JSON.stringify(component, null, 2));
    commit('SET_ACTIVE', component);
  }
};
