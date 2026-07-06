<template>
    <header class="bg-header border-b border-border flex items-center justify-between px-6 py-4 shadow-sm">
        <div class="flex items-center">
            <h2 class="text-xl font-semibold text-text">Dashboard</h2>
        </div>

        <div class="flex items-center space-x-4">
            <span class="text-sm font-medium text-text">
                {{ authStore.user?.username }}
            </span>
            <button @click="handleLogout"
                class="text-sm bg-background hover:bg-hover border border-border text-text px-4 py-2 rounded-lg transition-colors shadow-sm cursor-pointer"
                :disabled="authStore.loading">
                Logout
            </button>
        </div>
    </header>
</template>

<script setup>
import { useAuthStore } from '../store/auth';
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const router = useRouter();

const handleLogout = async () => {
    try {
        await authStore.logout();
        await router.push({ name: 'Login' });
    } catch (error) {
        if (import.meta.env.DEV) {
            console.error('Logout redirect failed:', error);
        }
    }
};
</script>
