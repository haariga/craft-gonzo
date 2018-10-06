import Vue from 'vue';

import VueRouter from 'vue-router';

import Home from '@Views/Home';
import AppComponent from '@Views/AppComponent';

Vue.use(VueRouter);

export default new VueRouter({
  routes: [
    {
      path: '/',
      component: Home,
    },
    {
      path: '/component/:name',
      component: AppComponent,
    },
  ],
});
