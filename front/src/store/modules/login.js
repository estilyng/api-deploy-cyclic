import axios from 'axios'
import localForage from 'localforage'
import dataAccess from '../dataAccessApi'

export default {
    state: {
        auth: {},
        token: '',
        logged: false,
    },
    mutations: {
        setDataLogged(state, user) {
            state.auth = user
            state.logged = true
        },
        setDataLogoff(state) {
            state.logged = false
            localStorage.removeItem('access_token')
            localForage.clear().then(() => {
                return localForage.clear()
            });
            state.token = null
            state.auth = null
        },

    },
    actions: {
        login({ commit, state }, crentls) {
            return new Promise((resolve, reject) => {
                axios.post('login', crentls)
                    .then(resp => {
                        if (resp.data) {
                            commit('setDataLogged', resp.data.user)
                            if (resp.data.access_token) {
                                state.token = resp.data.access_token
                                localStorage.setItem('access_token', resp.data.access_token)
                            }
                            resolve(resp)
                        }
                    })
                    .catch(error => {
                        console.log(error.response.data)
                        return reject(error)
                    })
            })
        },
        logout({ commit }, token) {
            return new Promise((resolve, reject) => {
                axios.post('logout', dataAccess, {
                    headers: { Authorization: `Bearer ${token}` }
                }).then(response => {
                    commit('setDataLogoff', token)

                    resolve(response)
                }).catch(error => {
                    console.log(error.response.data.errors)
                    reject(error)
                })
            })
        },

        getAuth({ commit }) {
            new Promise((resolve, reject) => {
                axios.get('auth', { headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` } })
                    .then((resp) => {
                        commit('setDataLogged', resp.data)
                        return resolve(resp.data)
                    })
                    .catch((error) => {
                        reject(error)
                        return console.log(error.response.data)
                    });
            });
        },

    },

    getters: {
        logged(state) {
            return state.logged
        },
        auth: (state) => state.auth
    },
}