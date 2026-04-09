import Chat from '@/layouts/Chat.vue';
import { defineAsyncComponent } from 'vue'

export default [
    {
        path: '/chat',
        component: Chat,
        children: [
            {
                path: '',
                name: 'chat',
                component: defineAsyncComponent(()=> import('@/views/Chat.vue')),
                meta : { module: "chat" },
            },
            {
                path: 'rid-:roomId',
                name: 'chat-room',
                component: defineAsyncComponent(()=> import('@/views/Chat.vue')),
                meta : { module: "chat" },
            },
            {
                path: 'rid-:roomId-:position',
                name: 'chat-room-position',
                component: defineAsyncComponent(()=> import('@/views/Chat.vue')),
                meta : { module: "chat" },
            }
        ]
    }
];

