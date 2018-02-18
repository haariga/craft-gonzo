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

import 'babel-polyfill';

import Vue from 'vue';
import axios from 'axios';
import './scss/app.scss';
import store from './store';
import App from './App';

Vue.component('patternlib', App);

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.baseURL = window.patternlibBaseUrl;
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = window.csrfToken;

new Vue({
  el: '#patternlib',
  store,
});
