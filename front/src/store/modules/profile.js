import axios from 'axios'
// import firebase from 'firebase'
// import localforage from 'localforage'

export default {
    state: {
        user: {}
    },
    mutations: {

    },
    actions: {
        getUserProfile({ commit }) {
            return new Promise((resolve, reject) => {
                axios('/profile', {
                        headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
                    }).then(resp => {
                        console.log(resp.data)
                        commit('notCommit')
                        return resolve(resp)
                    })
                    .catch(error => {
                        console.log(error.response)
                        return reject(error)
                    })
            });
        },

        updateUserProfile({ commit }, user) {
            return new Promise((resolve, reject) => {
                axios.put(`profile/${user.id}`, user, {
                        headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
                    })
                    .then(resp => {
                        console.log(resp.data)
                        commit('notCommit')
                        return resolve(resp)
                    })
                    .catch(error => {
                        console.log(error.response.data)
                        return reject(error.response.data)
                    })
            });
        },

        updatePhotoProfile({ commit }, file) {

            const formData = new FormData()
            formData.append('file', file);

            return new Promise((resolve, reject) => {
                axios.post('profile/', formData, {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem('access_token')}`,
                            'Content-Type': 'multipart/form-data',
                            'Access-Control-Allow-Origin': '*'
                        },
                    })
                    .then(resp => {
                        console.log(resp.data)

                        commit('notCommit')
                        return resolve(resp)
                    })
                    .catch(error => {
                        // console.log(error.response.data)
                        return reject(error.response.data)
                    })
            });
        },
    },
    getters: {},
}