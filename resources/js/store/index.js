import Vue from 'vue';
import Vuex from 'vuex';

import authentication from './modules/authentication';
import notification from './modules/notification';

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        authentication,
        notification
    }
});
