require('./bootstrap');

import Vue from 'vue';
import VueI18n from 'vue-i18n';
import { ZiggyVue } from 'ziggy';
import { Ziggy } from './ziggy';
import VueRouter from 'vue-router';
import routes from './router/routes';
import App from './App.vue';

import messages from "./lang/index";

Vue.use(VueI18n);
Vue.use(ZiggyVue, Ziggy);
Vue.use(VueRouter);

const i18n = new VueI18n({
   locale: 'de',
   messages
});

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    i18n,
    components: { App }
});
