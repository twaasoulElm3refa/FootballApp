<template>
    <div class="admin-login-page">
        <div class="login-bg-glow login-bg-glow-one"></div>
        <div class="login-bg-glow login-bg-glow-two"></div>

        <div class="login-shell">
            <div class="login-brand-side">
                <div class="brand-orbit">
                    <span class="brand-ring brand-ring-one"></span>
                    <span class="brand-ring brand-ring-two"></span>

                    <div class="brand-logo-box">
                        <img :src="logoUrl" alt="FootballApp Logo">
                    </div>
                </div>

                <div class="brand-badge">
                    <span></span>
                    Football Admin
                </div>

                <h1>
                    Control Your<br>
                    Football Platform
                </h1>

                <p>
                    Manage users, leagues, teams, fixtures, live scores, sync logs,
                    notifications, and everything behind your football experience.
                </p>

                <div class="brand-features">
                    <div>
                        <strong>Live</strong>
                        <span>Match Control</span>
                    </div>
                    <div>
                        <strong>API</strong>
                        <span>Usage Monitor</span>
                    </div>
                    <div>
                        <strong>Sync</strong>
                        <span>Football Data</span>
                    </div>
                </div>
            </div>

            <div class="login-card">
                <div class="mobile-logo">
                    <div class="mobile-logo-box">
                        <img :src="logoUrl" alt="FootballApp Logo">
                    </div>
                </div>

                <div class="login-header">
                    <p class="login-kicker">Welcome Back</p>
                    <h2>Admin Portal</h2>
                    <p>Sign in to access your dashboard</p>
                </div>

                <form class="login-form" @submit.prevent="handleLogin">
                    <div class="form-group">
                        <label for="email-address">Email address</label>
                        <div class="input-wrap">
                            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 12H8m8 0l-4 4m4-4l-4-4m8 10H4a2 2 0 01-2-2V6a2 2 0 012-2h16a2 2 0 012 2v10a2 2 0 01-2 2z"
                                />
                            </svg>

                            <input
                                id="email-address"
                                v-model="email"
                                name="email"
                                type="email"
                                autocomplete="email"
                                required
                                placeholder="admin@example.com"
                            />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrap">
                            <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3zm0 0v3m-6 6h12a2 2 0 002-2v-3a6 6 0 00-12 0v3a2 2 0 002 2z"
                                />
                            </svg>

                            <input
                                id="password"
                                v-model="password"
                                name="password"
                                :type="showPassword ? 'text' : 'password'"
                                autocomplete="current-password"
                                required
                                placeholder="Enter password"
                            />

                            <button
                                type="button"
                                class="password-toggle"
                                @click="showPassword = !showPassword"
                            >
                                {{ showPassword ? 'Hide' : 'Show' }}
                            </button>
                        </div>
                    </div>

                    <div v-if="errorMsg" class="error-box">
                        {{ errorMsg }}
                    </div>

                    <button
                        type="submit"
                        :disabled="authStore.loading"
                        class="login-button"
                    >
                        <span v-if="authStore.loading" class="button-loading">
                            <span class="spinner"></span>
                            Signing in...
                        </span>

                        <span v-else>
                            Sign in
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"
                                />
                            </svg>
                        </span>
                    </button>
                </form>

                <div class="login-footer">
                    Secure access for FootballApp administrators only.
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useAuthStore } from '../store/auth';
import { useRoute, useRouter } from 'vue-router';

const email = ref('');
const password = ref('');
const showPassword = ref(false);
const errorMsg = ref('');

const logoUrl = computed(() => window.appConfig?.logoUrl || '/images/logo.png');

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

<style scoped>
.admin-login-page {
    position: relative;
    min-height: 100vh;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 28px;
    color: var(--color-text-primary);
    background: var(--gradient-login-bg);
}

.login-bg-glow {
    position: absolute;
    width: 520px;
    height: 520px;
    border-radius: var(--radius-full);
    filter: blur(30px);
    opacity: 0.55;
    pointer-events: none;
}

.login-bg-glow-one {
    top: -220px;
    left: -160px;
    background: var(--gradient-green-glow-strong);
}

.login-bg-glow-two {
    right: -180px;
    bottom: -220px;
    background: var(--gradient-cyan-glow-strong);
}

.login-shell {
    position: relative;
    z-index: 2;
    width: min(100%, 1080px);
    min-height: 620px;
    display: grid;
    grid-template-columns: 1.05fr 0.95fr;
    border: 1px solid var(--color-border-light);
    border-radius: var(--radius-2xl);
    overflow: hidden;
    background: var(--color-deep-navy-72);
    box-shadow: var(--shadow-login-shell);
    backdrop-filter: blur(22px);
}

.login-brand-side {
    position: relative;
    padding: 56px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    overflow: hidden;
    background: var(--gradient-login-brand-side);
}

.brand-orbit {
    position: relative;
    width: 176px;
    height: 176px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 26px;
}

.brand-ring {
    position: absolute;
    border-radius: var(--radius-full);
    background: var(--gradient-admin-ring);
    -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 5px), var(--color-black) calc(100% - 5px));
    mask: radial-gradient(farthest-side, transparent calc(100% - 5px), var(--color-black) calc(100% - 5px));
    filter: var(--filter-admin-ring);
}

.brand-ring-one {
    inset: 0;
    animation: loginSpin 8s linear infinite;
}

.brand-ring-two {
    inset: 17px;
    opacity: 0.48;
    animation: loginSpinReverse 11s linear infinite;
}

.brand-logo-box,
.mobile-logo-box {
    position: relative;
    z-index: 3;
    background: var(--color-white);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-logo-box);
}

.brand-logo-box {
    width: 86px;
    height: 86px;
    border-radius: 24px;
}

.brand-logo-box img,
.mobile-logo-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.brand-badge {
    width: fit-content;
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 9px 15px;
    border-radius: var(--radius-full);
    color: var(--color-cyan);
    font-size: 13px;
    font-weight: 900;
    background: var(--color-cyan-08);
    border: 1px solid var(--color-cyan-28);
    margin-bottom: 22px;
}

.brand-badge span {
    width: 8px;
    height: 8px;
    border-radius: var(--radius-full);
    background: var(--color-green);
    box-shadow: var(--glow-green);
}

.login-brand-side h1 {
    max-width: 440px;
    font-size: clamp(42px, 5vw, 64px);
    line-height: 0.95;
    font-weight: 950;
    letter-spacing: -0.04em;
    color: var(--color-text-primary);
}

.login-brand-side p {
    max-width: 470px;
    margin-top: 22px;
    color: var(--color-text-muted);
    line-height: 1.8;
    font-size: 16px;
}

.brand-features {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    margin-top: 34px;
}

.brand-features div {
    padding: 14px;
    border-radius: 18px;
    background: var(--color-white-06);
    border: 1px solid var(--color-border-light);
}

.brand-features strong {
    display: block;
    color: var(--color-green);
    font-size: 18px;
    font-weight: 950;
}

.brand-features span {
    display: block;
    margin-top: 3px;
    color: var(--color-white-66);
    font-size: 12px;
    font-weight: 700;
}

.login-card {
    padding: 56px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: var(--color-surface-white);
    color: var(--color-text-dark);
}

.mobile-logo {
    display: none;
    justify-content: center;
    margin-bottom: 18px;
}

.mobile-logo-box {
    width: 74px;
    height: 74px;
    border-radius: 22px;
}

.login-header {
    text-align: left;
    margin-bottom: 32px;
}

.login-kicker {
    color: var(--color-admin-accent);
    font-size: 13px;
    font-weight: 950;
    letter-spacing: 0.05em;
    text-transform: uppercase;
}

.login-header h2 {
    margin-top: 8px;
    color: var(--color-text-dark);
    font-size: 34px;
    line-height: 1;
    font-weight: 950;
    letter-spacing: -0.03em;
}

.login-header p:last-child {
    margin-top: 10px;
    color: var(--color-text-muted-dark);
    font-size: 14px;
    font-weight: 600;
}

.login-form {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    color: var(--color-text-label);
    font-size: 13px;
    font-weight: 900;
}

.input-wrap {
    position: relative;
}

.input-wrap input {
    width: 100%;
    height: 54px;
    padding: 0 92px 0 46px;
    border-radius: var(--radius-md);
    border: 1px solid var(--color-border-dark);
    outline: none;
    background: var(--color-input-bg);
    color: var(--color-text-dark);
    font-size: 14px;
    font-weight: 700;
    transition: all 0.24s ease;
}

.input-wrap input::placeholder {
    color: var(--color-input-placeholder);
    font-weight: 600;
}

.input-wrap input:focus {
    border-color: var(--color-cyan-75);
    background: var(--color-white);
    box-shadow: var(--shadow-input-focus);
}

.input-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    width: 20px;
    height: 20px;
    transform: translateY(-50%);
    color: var(--color-admin-accent);
    pointer-events: none;
}

.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    border: 0;
    background: transparent;
    color: var(--color-admin-accent);
    font-size: 12px;
    font-weight: 950;
    cursor: pointer;
}

.error-box {
    padding: 12px 14px;
    border-radius: 14px;
    color: var(--color-error-text);
    background: var(--color-error-bg);
    border: 1px solid var(--color-error-border);
    font-size: 13px;
    font-weight: 800;
    text-align: center;
}

.login-button {
    width: 100%;
    height: 56px;
    border: 0;
    border-radius: 18px;
    color: var(--color-brand-ink);
    background: var(--gradient-brand);
    font-size: 15px;
    font-weight: 950;
    cursor: pointer;
    box-shadow: var(--shadow-login-button);
    transition: transform 0.24s ease, box-shadow 0.24s ease, opacity 0.24s ease;
}

.login-button:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-login-button-hover);
}

.login-button:disabled {
    opacity: 0.72;
    cursor: not-allowed;
    transform: none;
}

.login-button span {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.login-button svg {
    width: 18px;
    height: 18px;
}

.button-loading {
    color: var(--color-brand-ink);
}

.spinner {
    width: 17px;
    height: 17px;
    border-radius: var(--radius-full);
    border: 2px solid var(--color-brand-ink-28);
    border-top-color: var(--color-brand-ink);
    animation: loginSpin 0.8s linear infinite;
}

.login-footer {
    margin-top: 22px;
    text-align: center;
    color: var(--color-text-muted-dark);
    font-size: 12px;
    font-weight: 700;
}

@keyframes loginSpin {
    to {
        transform: rotate(360deg);
    }
}

@keyframes loginSpinReverse {
    to {
        transform: rotate(-360deg);
    }
}

@media (max-width: 980px) {
    .login-shell {
        grid-template-columns: 1fr;
        width: min(100%, 520px);
        min-height: auto;
    }

    .login-brand-side {
        display: none;
    }

    .login-card {
        padding: 38px 28px;
    }

    .mobile-logo {
        display: flex;
    }

    .login-header {
        text-align: center;
    }
}

@media (max-width: 520px) {
    .admin-login-page {
        padding: 16px;
    }

    .login-card {
        padding: 30px 20px;
    }

    .login-header h2 {
        font-size: 30px;
    }

    .input-wrap input {
        height: 52px;
    }
}
</style>
