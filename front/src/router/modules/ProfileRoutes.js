import Profile from '@/views/profile/Profile'

export default [{
    name: 'profile',
    path: '/profile',
    component: Profile,
    meta: {
        requireAuth: true,
        grantAll: false,
        grants: ['administrador', 'direcionador', 'solucionador', 'operador']
    }
}]