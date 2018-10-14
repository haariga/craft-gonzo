import Vue from 'vue';

import VueRouter from 'vue-router';

import Home from '@Views/Home';
import AppComponent from '@Views/AppComponent';
import PatternlibPages from '@Views/Patternlib-Pages';

Vue.use(VueRouter);

export default new VueRouter({
  routes: [
    {
      name: 'Home',
      path: '/',
      component: Home,
    },
    {
      path: '/component/:name',
      component: AppComponent,
    },
    {
      path: '/pages/:name',
      component: PatternlibPages,
    },
  ],
});
