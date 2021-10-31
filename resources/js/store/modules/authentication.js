const state = () => ({
    authenticated: false,
    access_token: null
})

const mutations = {
    setToken (state, token) {
        state.access_token = token;
        state.authenticated = true;
    },
    deleteToken (state) {
        if (!state.access_token) return false;

        delete state.access_token;
        state.authenticated = false;
    }
}

export default {
 namespaced: true,
 state,
 getters: {},
 actions: {},
 mutations
}
