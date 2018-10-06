/**
 * Craft Gonzo Plugin for Craft CMS
 *
 * Craft Patternlib JS
 *
 * @author    Martin Herweg
 * @copyright Copyright (c) 2017 Martin Herweg
 * @link      https://martinherweg.de
 * @package   CraftPatternlib
 * @since     0.0.1
 */

import Vue from 'vue';
import axios from 'axios';
import { sync } from 'vuex-router-sync';
import App from './vue/App';
import store from './vue/store';
import router from './vue/router';
import './scss/app.scss'; // eslint-disable-line

Vue.component('patternlib', App);

const unsync = sync(store, router); // eslint-disable-line

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseURL = window.patternlibBaseUrl;
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.csrfToken;

new Vue({
  el: '#patternlib',
  store,
  router,
});
