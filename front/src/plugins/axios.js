import axios from 'axios'
import router from '@/router/routers'


// axios.defaults.baseURL = 'http://131.255.233.6:8008/api/';
axios.defaults.baseURL = 'http://localhost:8000/api/';

axios.defaults.headers.common['Authorization'] = "Bearer " + localStorage.getItem('access_token');
axios.defaults.headers.common['Accept'] = 'application/json';

axios.interceptors.response.use((resp) => {
    return Promise.resolve(resp);
}, error => {
    if (error.response.status === 401) {
        localStorage.removeItem('access_token')
        return router.replace({ name: 'login' })
    } else return Promise.reject(error);
})