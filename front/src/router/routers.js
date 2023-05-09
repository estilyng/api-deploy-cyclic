import Vue from 'vue'
import VueRouter from 'vue-router'
import localForage from 'localforage'

import UsersRouters from './modules/usersRouters'
import ServicesRouters from './modules/ServicesRouters'
import CallsRouters from './modules/CallsRouters'
import ProfileRouters from './modules/ProfileRoutes'
import HelpersRouters from './modules/HelpersRoutes'
import ChatRouter from './modules/Chat'

import Home from '@/views/home/ControllerHome'
import Login from '@/views/login/Login'
import Unauthorized from '@/views/aborts/401'
import CallsPerSolver from '@/views/home/CallsPerSolvers'




Vue.use(VueRouter)

const routes = [{
        path: '/login',
        component: Login,
        name: 'login',
        meta: {
            requireAuth: false,
            grantAll: true,
        },
    },
    {
        path: '/',
        redirect: '/home'
    },
    {
        path: '/home',
        name: 'home',
        component: Home,
        children: [{
            path: "solver/:id",
            name: "callsSolver",
            component: CallsPerSolver,
            props: true,
            meta: {
                requireAuth: true,
                grantAll: false,
                grants: ['administrador', 'direcionador', 'solucionador']
            },
        }],
        meta: {
            requireAuth: true,
            grantAll: false,
            grants: ['administrador', 'direcionador', 'solucionador', 'operador', ]
        },
    },
    ...UsersRouters,
    ...ServicesRouters,
    ...CallsRouters,
    ...ProfileRouters,
    ...HelpersRouters,
    ...ChatRouter,

    { name: 'error401', path: '/unauthorized', component: Unauthorized },
    { path: '*', component: Home },
]


const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
})


router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('access_token')

    if (to.name !== 'login' && !token) {
        next('/login')
    } else {
        console.clear()
        next()
    }

    if (to.meta.requireAuth) {
        console.clear()
            // cargar data auth localStorage
        localForage.getItem('helpDesk').then(value => {
            const roles = value.login.auth.roles.map(r => r.name)

            const rolesEgrants = to.meta.grants.filter(item => {
                if (roles.includes(item)) {
                    return item
                } else { return false }

            })
            if (token && rolesEgrants) {
                next()
            }
            if (token && rolesEgrants == '') {
                next({ name: 'error401' });
            }

        }).catch(error => console.log(error));

    }

});

export default router;