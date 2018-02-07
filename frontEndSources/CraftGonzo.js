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
import './scss/app.scss';
import store from './store';
import App from './App';

Vue.component('patternlib', App);

new Vue({
  el: '#patternlib',
  store
});
