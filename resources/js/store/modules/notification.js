const state = () => ({
   notifications: [

   ]
})

const getters = {

}

const actions = {

}

const mutations = {
    addNotification (state, data) {
        state.notifications.push({'type': data.type, 'message': data.message});
    }
}

export default {
 namespaced: true,
 state,
 getters,
 actions,
 mutations
}
