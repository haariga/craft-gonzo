import Vue from 'vue';

import VueRouter from 'vue-router';
import Meta from 'vue-meta';
import animateScrollTo from 'animated-scroll-to';

import Home from '@Views/Home';
import AppComponent from '@Views/AppComponent';
import PatternlibPages from '@Views/Patternlib-Pages';

Vue.use(VueRouter);
Vue.use(Meta);

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
  scrollBehavior(to, from, savedPosition) {
    if (to.path !== from.path) {
      return new Promise((resolve, reject) => {
        setTimeout(() => animateScrollTo(0), 250);
      });
    }

    return savedPosition;
  },
});
