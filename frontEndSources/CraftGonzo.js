/**
 * Craft Gonzo Plugin for Craft CMS
 *
 * Craft Styleguide JS
 *
 * @author    Martin Herweg
 * @copyright Copyright (c) 2017 Martin Herweg
 * @link      https://martinherweg.de
 * @package   CraftStyleguide
 * @since     0.0.1
 */

import Vue from 'vue';
import './scss/app.scss';
import store from './store';
import App from './App';

Vue.component('styleguide', App);

new Vue({
  el: '#styleguide',
  store
});
