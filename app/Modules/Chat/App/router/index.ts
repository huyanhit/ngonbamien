import {createRouter, createWebHistory} from 'vue-router';
import {privateRoutes} from './private-routes';

const router = createRouter({
    history: createWebHistory(),
    routes: [...privateRoutes],
});

export default router;
