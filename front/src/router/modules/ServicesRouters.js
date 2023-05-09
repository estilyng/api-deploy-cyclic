import ConfigComponent from '@/views/configations/Config'

export default [

    { 
        name: 'services', 
        path: '/configure', 
        component: ConfigComponent,
        meta: {
            requireAuth: true,
            grantAll: false,
            grants: ['administrador', 'direcionador', 'solucionador']
        }
     },

]