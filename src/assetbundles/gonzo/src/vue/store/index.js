import Vue from 'vue';
import Vuex from 'vuex';
import getters from './getters';
import actions from './actions';
import mutations from './mutations';

Vue.use(Vuex);

const state = {
  filelist: window.filelist,
};

const store = new Vuex.Store({
  state,
  getters,
  actions,
  mutations,
});

/* eslint-disable */
if (module.hot) {
  // accept actions and mutations as hot modules
  module.hot.accept(['./getters', './actions', './mutations'], () => {
    // swap in the new actions and mutations
    store.hotUpdate({
      getters: require('./getters'),
      actions: require('./actions'),
      mutations: require('./mutations'),
    });
  });
}

export default store;
