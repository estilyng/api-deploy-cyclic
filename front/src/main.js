import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify';
import router from '@/router/routers'
import store from './store'

import './plugins/firebase'
import './plugins/vee-validate'
import './registerServiceWorker'
import './plugins/axios'
import './plugins/echo'

import Toast from "vue-toastification";
// Import the CSS or use your own!
import "vue-toastification/dist/index.css";

const options = {
    transition: "Vue-Toastification__bounce",
    maxToasts: 25,
    newestOnTop: false
};


Vue.use(Toast, options);

Vue.config.productionTip = false

new Vue({
    router,
    vuetify,
    store,
    render: h => h(App)
}).$mount('#app')