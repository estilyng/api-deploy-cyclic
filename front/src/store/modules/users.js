import axios from 'axios'

export default {
    state: {
        users: [],
        roles: [],
    },
    mutations: {
        setUsers(state, users) {
            state.users = users
        },
        setRoles(state, roles) {
            state.roles = roles
        },
    },
    actions: {
        loadUsers({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/users', { headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` } })
                    .then((resp) => {
                        console.log('load users', resp.data)
                        commit('setUsers', resp.data)
                        return resolve(resp.data)
                    })
                    .catch((error) => {
                        reject(error)
                        return console.log(error.response.data)
                    });
            });
        },
        loadRoles({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get("/roles", { headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` } })
                    .then(resp => {
                        resolve(resp.data)
                        return commit('setRoles', resp.data)
                    })
                    .catch(error => {

                        return console.log(reject(error.response.data))
                    });
            })
        },

        storeUser({ dispatch }, user) {
            console.log('chegou no dispatch')
            return new Promise((resolve, reject) => {
                axios.post('users', user, {
                        headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
                    })
                    .then((resp) => {
                        dispatch('loadUsers')
                        return resolve(resp.data)
                    })
                    .catch((error) => {
                        return reject(error.response.data)
                    })
            })
        },
        updateUser({ dispatch, commit }, user) {
            return new Promise((resolve, reject) => {
                axios.put(`users/${user.id}`, user, {
                        headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
                    })
                    .then((resp) => {
                        dispatch('loadUsers')
                        commit('notCommit')
                        return resolve(resp)
                    })
                    .catch((error) => {
                        return reject(error)
                    })
            })
        },
        updateUserDriver({ commit }, user) {
            return new Promise((resolve, reject) => {
                console.log(user)
                axios.put(`user-activated/${user.id}`, user, {
                        headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
                    })
                    .then((resp) => {
                        console.log(resp.data)
                        commit('notCommit')
                        return resolve(resp.data)
                    })
                    .catch((error) => {
                        return reject(error.response.data)
                    })
            })
        },



        deleteUser({ dispatch, commit }, user_id) {
            return new Promise((resolve, reject) => {
                axios.delete(`users/${user_id}`, {
                        headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
                    })
                    .then((resp) => {
                        dispatch('loadUsers')
                        commit('notCommit')
                        return resolve(resp)
                    })
                    .catch((error) => {
                        return reject(error)
                    })
            })
        },
    },
    getters: {
        users: (state) => state.users,
        usersById: (state) => (id) => {
            return state.users.find(user => user.id == id)
        },
        roles: (state) => state.roles,
        // errorsUser: (state) => state.errors,
    },
}