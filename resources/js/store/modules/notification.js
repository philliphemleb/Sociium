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
        for (let i = 0; i < state.notifications.length; i++)
        {
            if (state.notifications[i].message === data.message) return false;
        }

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
