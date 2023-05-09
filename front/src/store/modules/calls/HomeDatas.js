import axios from 'axios'

export default {

    state: {
        statusAllCalls: null,
        callPerUserSolver: null,
        callPerUserAuth: null,
        search: null,
    },
    mutations: {
        setDatasStatusCalls(state, statusCalls) {
            state.statusAllCalls = statusCalls;
        },

        setcallPerUserSolver(state, callUsersSolvers) {
            state.callPerUserSolver = callUsersSolvers
        },

        setcallPerUserAuth(state, callsUsersAuth) {
            state.callPerUserAuth = callsUsersAuth
        },
        updateSerach(state, payload) {
            state.search = payload
        }

    },
    actions: {
        statusAllCalls({ commit }) {
            return new Promise((resolve, reject) => {
                return axios.get('/home/admin/status-calls', { headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` } })
                    .then(response => {

                        commit('setDatasStatusCalls', response.data)
                        return resolve(response.data)
                    })
                    .catch(error => {
                        return reject(error)
                    })
            });
        },

        callPerUserSolver({ commit }) {
            return new Promise((resolve, reject) => {
                return axios.get('/home/admin/status-calls-solvers', { headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` } })
                    .then(response => {

                        commit('setcallPerUserSolver', response.data)

                        return resolve(response.data)
                    })
                    .catch(error => {
                        reject(error)
                        console.log(error)
                    })
            });
        },

        callPerUserAuth({ commit }) {
            return new Promise((resolve, reject) => {
                return axios.get('/home/status-calls-auth', { headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` } })
                    .then(response => {
                        console.log('return response of dispatch', response.data)

                        commit('setcallPerUserAuth', response.data)

                        return resolve(response.data)
                    })
                    .catch(error => {
                        reject(error)
                        console.log(error)
                    })
            });
        },

        async detailsCallsPerSolver({ commit }, user_id) {
            try {
                const resp = await axios.get('home/details-calls-solver/' + user_id, {
                    headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
                })
                commit('notCommit')
                return resp
            } catch (error) {
                console.log(error)
            }
        }
    },
    getters: {
        datasStatusCalls: (state) => state.datasStatusCalls,
        callPerUserSolver: (state) => state.callPerUserSolver,
        callPerUserAuth: (state) => state.callPerUserAuth,
        search: (state) => state.search,
    }
}