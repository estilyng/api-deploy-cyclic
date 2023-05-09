// import Chat from '@/views/chat/Chat'

export default [{
    name: 'chat',
    path: '/chat',
    component: () =>
        import ('@/views/chat/Chat'),
}, ];