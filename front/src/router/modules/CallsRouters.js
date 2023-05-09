import Calls from '@/views/orders_services/OrdersServices'
import OrderEdit from '@/views/orders_services/OrderEdit'

export default [{
        name: 'calls',
        path: '/calls',
        component: Calls,
    },
    {
        name: 'callsEdit',
        path: '/calls/:id/edit',
        component: OrderEdit,
        props: true
    }
];