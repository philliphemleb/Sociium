const state = () => ({
   notifications: []
})

const mutations = {
    addNotification (state, data) {
        for (let i = 0; i < state.notifications.length; i++)
        {
            if (state.notifications[i].message === data.message) return false;
        }

        state.notifications.push({'type': data.type, 'message': data.message});
    },
    deleteNotification (state, message) {
        console.log(state.notifications);

        for (let i = 0; i < state.notifications.length; i++)
        {
            if (state.notifications[i].message === message)
            {
                state.notifications.splice(i, 1);
            }
        }

        console.log(state.notifications);
    }
}

export default {
 namespaced: true,
 state,
 getters: {},
 actions: {},
 mutations
}
