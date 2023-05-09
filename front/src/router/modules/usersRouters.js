import Users from '@/views/users/Users'

import UserCreate from '@/views/users/UserCreate'
import UserEdit from '@/views/users/UserEdit'

const UsersRouters = [{
        name: 'users',
        path: '/users',
        component: Users,
        meta: {
            requireAuth: true,
            grantAll: false,
            grants: ['administrador', 'direcionador']
        },
    },
    {
        name: 'users.create',
        path: '/users/create',
        component: UserCreate,
        meta: {
            requireAuth: true,
            grantAll: false,
            grants: ['administrador', 'direcionador']
        }
    },
    {
        name: 'usersEdit',
        path: '/users/:id/edit',
        component: UserEdit,
        props: true,
        meta: {
            requireAuth: true,
            grantAll: false,
            grants: ['administrador', 'direcionador']
        }
    }
];


export default UsersRouters