import axios from 'axios'
import localforage from 'localforage'
import Vue from 'vue'


export default {
    state: {
        chatUsers: [],
        messages: [],
        to: '',
        currentMessages: [],
        sendMessage: false,
        drawer: false
    },
    mutations: {
        SET_MESSAGES(state, messages) {
            state.messages = messages
        },

        SET_CHAT_USERS(state, chatUsers) {
            state.chatUsers = chatUsers
        },

        SET_CURRENT_MESSAGE(state, userTo) {
            localforage.getItem('helpDesk').then(item => {
                const auth = item.login.auth
                state.to = userTo.id

                const messages = state.messages.filter(message => {
                    const authMessage = message.from === auth.id && message.to === userTo.id
                    const userMessage = message.from === userTo.id && message.to === auth.id

                    return authMessage || userMessage
                })

                if (messages.length) {
                    state.currentMessages = messages
                } else {

                    const operator = auth.roles.find(role => role.name === 'operador')

                    if (operator) {

                        const message = {
                            from: userTo.id,
                            to: auth.id,
                            content: `Olá! me chamo ${userTo.name}. em que posso ajudar?`,
                        };

                        state.currentMessages = []
                        state.currentMessages.push(message)
                    } else {
                        state.currentMessages = []

                    }
                }
            })
        },

        CLEAN_CURRENT_MESSAGE(state) {
            state.currentMessages = []
        },

        SEND_NEW_MESSAGE(state, message) {
            state.messages.push(message)
            console.log('mutation send message', message)


            console.log('state users', state.chatUsers)
            state.currentMessages.push(message)
            state.sendMessage = !state.sendMessage
        },

        ACTIVE_CIRCLE_NOTIFY(state, from) {
            const index = state.chatUsers.findIndex(u => u.id === from)

            Vue.set(state.chatUsers[index], 'read', false)
        },

        DEACTIVATE_CIRCLE_NOTIFY(state, to) {
            const index = state.chatUsers.findIndex(u => u.id === to)
            console.log(index)

            Vue.set(state.chatUsers[index], 'read', true)
        },

        UPDATE_DRAWER(state, drawer) {
            state.drawer = drawer
        }

    },
    actions: {
        loadMessages({ commit }) {
            return new Promise((resolve, reject) => {
                axios('chat-messages', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('access_token')}`,
                    }
                }).then(resp => {
                    resolve(resp.data.messages)
                    commit('SET_MESSAGES', resp.data.messages)
                    console.log(resp)
                })
                    .catch(error => {
                        reject(error)
                        console.log(error)
                    })
            })
        },

        load_chat_user({ commit }) {
            return new Promise((resolve, reject) => {
                axios('chat-users', {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('access_token')}`,
                    }
                }).then(resp => {
                    console.log(resp.data.chatUsers)
                    commit('SET_CHAT_USERS', resp.data.chatUsers)
                    return resolve(resp.data.chatUsers)
                })
                    .catch(error => {
                        reject(error)
                        console.log(error)
                    })
            })
        },

        send_new_message({ commit }, message) {
            return new Promise(() => {
                axios.post('chat-send-message', message, {
                    headers: {
                        Authorization: `Bearer ${localStorage.getItem('access_token')}`,
                    }
                }).then(resp => {
                    console.log(resp)
                    commit('SEND_NEW_MESSAGE', message)
                }).catch(erro => console.log(erro))
            })
        },

    },
    getters: {
        getMessages: (state) => state.messages,
        getcurrentMessages: (state) => state.currentMessages.sort((a, b) => {
            return a.id < b.id ? -1 : a.id > b.id ? 1 : 0;
        }),

        getChatUsers: (state) => state.chatUsers,

        getSendMessage: (state) => state.sendMessage,

        getTo: (state) => state.to,

        getDrawer: (state) => state.drawer
    },
}