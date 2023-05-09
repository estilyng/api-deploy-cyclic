import Vue from 'vue'
import Vuex from 'vuex'
import VuexPersist from 'vuex-persist'
import localForage from 'localforage'


// import modules
import users from './modules/users'
import login from './modules/login'
import services from './modules/services'
import calls from './modules/calls/calls'
import notifications from './modules/notifications'
import profile from './modules/profile'
import messages from './modules/calls/messages'

Vue.use(Vuex)

const vuexStorage = new VuexPersist({
    key: 'helpDesk',
    storage: localForage,
    asyncStorage: true,
    saveState: (key, state, storage) => Promise.resolve(storage.setItem(key, state)),
    modules: ['login']
})

export default new Vuex.Store({
    plugins: [vuexStorage.plugin],
    state: {
        btnSideBar: null,
        loading: false,
        toastErrorNotify: false,
        callError: null,
        itemsPerPageCalls: 2,
        pageCalls: 1,
    },
    mutations: {

        activeSideBar(state) {
            state.btnSideBar = !state.btnSideBar
        },

        updateBtnSideBar(state, value) {
            state.btnSideBar = value
        },


        setLoading(state, payload) {
            state.loading = payload
        },

        updatetoastErrorNotify(state, value) {
            state.toastErrorNotify = value
        },

        setCallError(state, call) {
            state.callError = call
        },

        updateItemPerPage(state, payload) {
            state.itemsPerPageCalls = payload
        },

        updatePage(state, payload) {
            state.pageCalls = payload
        },

    },

    getters: {
        getBtnSideBar(state) {
            return state.btnSideBar
        },
        getcallError: (state) => state.callError,

        getItemsPerPage: state => state.itemsPerPageCalls,
        getPage: state => state.pageCalls,
    },
    modules: {
        users,
        login,
        services,
        calls,
        notifications,
        profile,
        messages
    }
})