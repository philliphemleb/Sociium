require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './router/routes';

import App from './App.vue';

Vue.use(VueRouter);

const app = new Vue({
    el: '#app',
    router: new VueRouter(routes),
    components: { App }
});
