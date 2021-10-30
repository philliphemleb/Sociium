require('./bootstrap');

import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import i18n from './lang';

import { ZiggyVue } from 'ziggy';
import { Ziggy } from './ziggy';
Vue.use(ZiggyVue, Ziggy);

const app = new Vue({
    el: '#app',
    router,
    store,
    i18n,
    components: { App }
});
