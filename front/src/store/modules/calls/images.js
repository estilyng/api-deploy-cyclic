import axios from 'axios'

// colocar o carregamento de imagens em stat

export default {

    state: {
        images: []
    },

    mutations: {
        ADD_IMAGE (state, image) {
            state.images.push(image)
         },
    },

    actions: {
        loadImagesCall ({ commit }, call_id) {
            return new Promise((resolve, reject) => {
                axios.get(`/images/${call_id}`, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('access_token')}`,
                        'Content-Type': 'image/jpeg'
                    }
                })
                    .then((resp) => {
                        commit('ADD_IMAGE', resp.data)
                        return resolve(resp.data)
                        // return resp.data
                    }).catch(error => {
                        reject(error)
                        return console.log(error.response.data)
                    })
            })
        }
    }

}