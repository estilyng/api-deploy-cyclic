import axios from 'axios'

export default {

    mutations: {
        updateSolverOfCall (state, data) {
            const i = state.calls.findIndex(item => item.id === data.call_id)
            delete state.calls[i].user
            state.calls[i] = data.user

            console.log(state.calls[i])
        },
    },

    actions: {
        loadSolver ({ commit }, call_id) {
            console.log('dispatch loadSolver')
            return new Promise((resolve, reject) => {
                axios.get(`call-solver/${call_id}`, {
                    headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
                }).then((resp) => {
                    commit('notCommit')
                    return resolve(resp.data)
                }).catch(error => {
                    return reject(error)
                })
            })
        },

        storeResponse ({ commit }, response) {
            const config = {
                headers: {
                    Authorization: `Bearer ${localStorage.getItem("access_token")}`,
                },
            };

            return new Promise((resolve, reject) => {
                axios.post(`responses`, response, config)
                    .then((resp) => {
                        console.log('action storeOrUpdateResponnse => success')
                        resolve(resp.data)
                        commit('notCommit', resp.data)
                        return console.log(resp.data)
                    })
                    .catch((error) => {
                        reject(error.response)
                        return console.log(error.response.data)
                    })
            })
        },

        updateSolverCall ({ commit }, solver) {
            console.log('dispatch updateSolverCall')
            new Promise((resolve, reject) => {
                axios.put(`call-solver/${solver.call_id}`, solver, {
                    headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
                }).then((resp) => {
                    resolve(resp.data)

                    // let user = getters.usersById(solver.user_id);

                    commit('notCommit')
                    return resolve(resp.data)
                }).catch(error => {
                    return reject(error)
                })
            })
        },
    }


}