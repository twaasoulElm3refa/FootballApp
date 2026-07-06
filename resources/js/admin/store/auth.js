import { defineStore } from 'pinia';
import api from '../utils/axios';

const getStoredAdminUser = () => {
    const storedUser = localStorage.getItem('admin_user');

    if (!storedUser) {
        return null;
    }

    try {
        return JSON.parse(storedUser);
    } catch (error) {
        localStorage.removeItem('admin_user');
        return null;
    }
};

const setAdminAuth = (token, user) => {
    localStorage.setItem('admin_token', token);
    api.defaults.headers.common['Authorization'] = `Bearer ${token}`;
};

const clearAdminAuth = () => {
    localStorage.removeItem('admin_token');
    delete api.defaults.headers.common['Authorization'];
};

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        loading: false,
    }),
    getters: {
        isAuthenticated: () => !!localStorage.getItem('admin_token'),
        isAdmin: (state) => {
            const user = state.user || getStoredAdminUser();

            return user?.role === 'admin';
        },
    },
    actions: {
        clearAuth() {
            this.user = null;
            clearAdminAuth();
        },
        async fetchUser() {
            this.loading = true;
            try {
                const response = await api.get('/me');
                const payload = response.data ?? response;

                this.user = payload.user;
            } catch (error) {
                this.clearAuth();
                throw error;
            } finally {
                this.loading = false;
            }
        },
        async login(credentials) {
            this.loading = true;
            try {
                const response = await api.post('/login', credentials);
                const payload = response.data ?? response;
                const token = payload.token;
                const user = payload.user;

                if (!token || !user) {
                    throw new Error('Invalid login response.');
                }

                if (user.role !== 'admin') {
                    throw new Error('This account is not allowed to access the admin dashboard.');
                }

                this.user = user;
                setAdminAuth(token, user);

                return { token, user };
            } catch (error) {
                this.clearAuth();
                throw error;
            } finally {
                this.loading = false;
            }
        },
        async logout() {
            this.loading = true;
            try {
                await api.post('/logout');
            } catch (error) {
                if (import.meta.env.DEV) {
                    console.error('Logout error', error);
                }
            } finally {
                this.clearAuth();
                this.loading = false;
            }
        }
    }
});
