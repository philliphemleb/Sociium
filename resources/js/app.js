require('./bootstrap');

import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import i18n from './lang';

import { ZiggyVue } from 'ziggy';
import { Ziggy } from './ziggy';
Vue.use(ZiggyVue, Ziggy);

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
        if (store.state.authentication.access_token) {
            next();
        }
        else {
            next({name: 'landingPage'});
        }
    }

    next();
});

const app = new Vue({
    el: '#app',
    router,
    store,
    i18n,
    components: { App }
});
