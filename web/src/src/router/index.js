import Vue from 'vue';
import VueRouter from 'vue-router';
import { sync } from 'vuex-router-sync';

import store from '../store';

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'home',
        component: () => import('../pages/Home.vue'),
    },
    {
        path: '/employee/create',
        name: 'employee.create',
        component: () => import('../pages/Employee/Form.vue'),
    },
    {
        path: '/employees',
        name: 'employee.index',
        component: () => import('../pages/Employee/List.vue'),
    },
    /**
     * Must be the last entry in array.
     */
    {
        path: '*',
        component: () => import('../pages/NotFound.vue'),
    },
];

const router = new VueRouter({
    routes,
    mode: 'history',
    linkActiveClass: 'active',
    scrollBehavior() {
        return {
            x: 0,
            y: 0,
        };
    },
});

sync(store, router);

export default router;
