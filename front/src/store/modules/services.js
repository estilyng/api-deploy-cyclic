import axios from 'axios'

export default {
    state: {
        services: [],
        errors: [],
    },
    mutations: {
        setServices(state, services) {
            state.services = services
        },
        storeService(state, service) {
            state.services.push(service);
        },
        deleteService(state, service_id) {
            const i = state.services.findIndex((item) => item.id === service_id)
            state.services.splice(i, 1);
        },
        updateService(state, service) {
            const i = state.services.findIndex(item => item.id === service.id)
            state.services[i] = service
        },
    },
    actions: {
        loadServices({ commit }) {
            return new Promise((resolve, reject) => {
                axios.get('/services', { headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` } }).then((resp) => {
                    resolve(resp.data)
                    return commit('setServices', resp.data)
                }).catch(error => {
                    return reject(error)
                })
            })
        },

        storeService({ commit }, service) {
            return new Promise((resolve, reject) => {
                return axios.post('services', service, {
                        headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
                    })
                    .then((resp) => {
                        commit('storeService', service)

                        return resolve(resp.data)
                    })
                    .catch((error) => {
                        return reject(error)
                    })
            })
        },
        updateService({ commit }, service) {
            return new Promise((resolve, reject) => {
                axios.put(`services/${service.id}`, service, {
                        headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
                    })
                    .then((resp) => {
                        commit('updateService', service)
                        return resolve(resp)

                    })
                    .catch((error) => {
                        return reject(error)
                    })
            })
        },
        deleteService({ commit }, service_id) {
            return new Promise((resolve, reject) => {
                axios.delete(`services/${service_id}`, {
                        headers: { Authorization: `Bearer ${localStorage.getItem('access_token')}` }
                    })
                    .then((resp) => {
                        commit('deleteService', service_id)
                        return resolve(resp)
                    })
                    .catch((error) => {
                        return reject(error)
                    })
            });
        },
    },
    getters: {
        services: (state) => state.services,
        serviceById: (state) => (id) => {
            return state.services.find(sv => sv.id == id)
        },
    },
}