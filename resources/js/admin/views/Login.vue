<template>
    <div class="min-h-screen flex items-center justify-center bg-background py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-surface p-10 rounded-2xl shadow-xl border border-border">
            <div>
                <h2 class="mt-2 text-center text-3xl font-extrabold text-text">
                    Admin Portal
                </h2>
                <p class="mt-2 text-center text-sm text-muted">
                    Sign in to access the dashboard
                </p>
            </div>

            <form class="mt-8 space-y-6" @submit.prevent="handleLogin">
                <div class="rounded-md shadow-sm space-y-4">
                    <div>
                        <label for="email-address" class="sr-only">Email address</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required
                            v-model="email"
                            class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-border placeholder-muted text-text focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:z-10 sm:text-sm transition-colors"
                            placeholder="Email address" />
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            v-model="password"
                            class="appearance-none rounded-xl relative block w-full px-4 py-3 border border-border placeholder-muted text-text focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary focus:z-10 sm:text-sm transition-colors"
                            placeholder="Password" />
                    </div>
                </div>

                <div v-if="errorMsg" class="text-danger text-sm text-center font-medium">
                    {{ errorMsg }}
                </div>

                <div>
                    <button type="submit" :disabled="authStore.loading"
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-xl text-white bg-primary hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all shadow-md cursor-pointer disabled:opacity-70 disabled:cursor-not-allowed">
                        <span v-if="authStore.loading">Signing in...</span>
                        <span v-else>Sign in</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '../store/auth';
import { useRoute, useRouter } from 'vue-router';

const email = ref('');
const password = ref('');
const errorMsg = ref('');
const authStore = useAuthStore();
const route = useRoute();
const router = useRouter();

const handleLogin = async () => {
    errorMsg.value = '';

    try {
        await authStore.login({
            email: email.value,
            password: password.value,
        });

        const redirectTo = typeof route.query.redirect === 'string'
            ? route.query.redirect
            : { name: 'Dashboard' };

        await router.push(redirectTo);
        window.location.reload();
    } catch (error) {
        if (import.meta.env.DEV) {
            console.error('Login failed:', error);
        }

        if (error.response && error.response.status === 401) {
            errorMsg.value = 'Invalid email or password.';
        } else if (error.response && error.response.data && error.response.data.message) {
            errorMsg.value = error.response.data.message;
        } else if (error.message) {
            errorMsg.value = error.message;
        } else {
            errorMsg.value = 'An error occurred during login.';
        }
    }
};
</script>
