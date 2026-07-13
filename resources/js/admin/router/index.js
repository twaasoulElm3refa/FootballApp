import { createRouter, createWebHistory } from 'vue-router';
import { useAuthStore } from '../store/auth';

import AdminLayout from '../layouts/AdminLayout.vue';
import Login from '../views/Login.vue';
import Dashboard from '../views/dashboard/Index.vue';

const routes = [
    {
        path: '/admin/login',
        name: 'Login',
        component: Login,
        meta: { guestOnly: true }
    },
    {
        path: '/admin',
        component: AdminLayout,
        meta: { requiresAuth: true, requiresAdmin: true },
        children: [
            {
                path: 'dashboard',
                name: 'Dashboard',
                component: Dashboard,
                meta: { requiresAuth: true, requiresAdmin: true },
            },
            {
                path: '',
                redirect: '/admin/dashboard'
            },

            // Users Routes
            {
                path: 'users',
                name: 'Users',
                component: () => import('../views/users/All_Users.vue'),
                meta: { requiresAuth: true, requiresAdmin: true },
            },
            {
                path: 'users/create',
                name: 'CreateUser',
                component: () => import('../views/users/Create_User.vue'),
                meta: { requiresAuth: true, requiresAdmin: true },
            },
            {
                path: 'users/:id',
                name: 'ShowUser',
                component: () => import('../views/users/Show_User.vue'),
                meta: { requiresAuth: true, requiresAdmin: true },
            },
            {
                path: 'users/:id/edit',
                name: 'EditUser',
                component: () => import('../views/users/Edit_User.vue'),
                meta: { requiresAuth: true, requiresAdmin: true },
            },

            // Leagues Routes
            {
                path: 'leagues',
                name: 'Leagues',
                component: () => import('../views/leagues/All_Leagues.vue'),
                meta: { requiresAuth: true, requiresAdmin: true },
            },
            {
                path: 'leagues/create',
                name: 'CreateLeague',
                component: () => import('../views/leagues/Create_League.vue'),
                meta: { requiresAuth: true, requiresAdmin: true },
            },
            {
                path: 'leagues/:id',
                name: 'ShowLeague',
                component: () => import('../views/leagues/Show_League.vue'),
                meta: { requiresAuth: true, requiresAdmin: true },
            },
            {
                path: 'leagues/:id/edit',
                name: 'EditLeague',
                component: () => import('../views/leagues/Edit_League.vue'),
                meta: { requiresAuth: true, requiresAdmin: true },
            },
            // {
            //     path: 'settings',
            //     name: 'Settings',
            //     component: () => import('../views/settings/Settings.vue'),
            //     meta: { requiresAuth: true, requiresAdmin: true },
            // }
        ]
    },
    {
        path: '/:pathMatch(.*)*',
        redirect: '/admin/dashboard'
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach(async (to) => {
    const authStore = useAuthStore();
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const requiresAdmin = to.matched.some(record => record.meta.requiresAdmin);
    const guestOnly = to.matched.some(record => record.meta.guestOnly);

    // Check if we need to fetch user on first load
    if (authStore.isAuthenticated && !authStore.user) {
        try {
            await authStore.fetchUser();
        } catch (e) {
            return { name: 'Login' };
        }
    }

    if (authStore.isAuthenticated && authStore.user && !authStore.isAdmin) {
        authStore.clearAuth();
        return { name: 'Login' };
    }

    if (requiresAuth && !authStore.isAuthenticated) {
        return { name: 'Login' };
    }

    if (requiresAdmin && !authStore.isAdmin) {
        authStore.clearAuth();
        return { name: 'Login' };
    }

    if (guestOnly && authStore.isAuthenticated) {
        return { name: 'Dashboard' };
    }

    return true;
});

export default router;
