import axios from 'axios'

// const config = { headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` } }
// const token = localStorage.getItem('access_token')

export default {
    state: {
        notifications: null,
    },
    mutations: {
        setNotifications(state, notifications) {
            if (notifications.length) {
                state.notifications = notifications
            }
        },
        setReadNotify(state, notify) {
            const i = state.notifications.findIndex(not => not.id == notify.id);
            console.log('setReadNotify mutations', i, state.notifications)
            state.notifications.splice(i, 1)
            if (state.notifications.length == 0) {
                state.notifications = null
            }
        },
        setReadAllNotify(state) {
            state.notifications = null
        },

    },
    actions: {

        allNotifications({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('notificable/calls', { headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` } }).then(resp => {
                    commit('setNotifications', resp.data)
                    resolve(resp.data)
                }).catch(error => {
                    // console.log(error);
                    reject(error.response.data)
                })
            });
        },

        readNotifyCall({ commit }, notify) {
            return new Promise((resolve, reject) => {
                axios.put('notificable/' + notify.id, '', { headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` } }).then(resp => {
                    commit('setReadNotify', notify)
                    resolve(resp.data)
                }).catch(error => {
                    console.log(error);
                    reject(error)
                })
            });
        },

        markReadAll({ commit }) {
            return new Promise((resolve, reject) => {
                axios.put('notificable/all', '', { headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` } })
                    .then(resp => {
                        commit('setReadAllNotify')
                        resolve(resp.data)
                    }).catch(error => {
                        console.log(error.response.data);
                        reject(error)
                    })
            });
        },

    },
    getters: {
        notifications: (state) => state.notifications
    },
}