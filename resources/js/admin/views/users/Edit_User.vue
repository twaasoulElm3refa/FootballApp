<template>
    <section class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-muted">Users</p>
                <h1 class="mt-1 text-3xl font-bold text-text">Edit User</h1>
                <p class="mt-2 text-sm text-muted">Update account details and access status.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <router-link
                    :to="{ name: 'Users' }"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-black shadow-sm transition hover:bg-gray-100"
                >
                    Back
                </router-link>
                <router-link
                    v-if="userId"
                    :to="{ name: 'ShowUser', params: { id: userId } }"
                    class="inline-flex items-center justify-center rounded-lg bg-black px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800"
                >
                    View User
                </router-link>
            </div>
        </div>

        <div
            v-if="successMessage"
            class="rounded-lg border border-gray-200 bg-white px-4 py-3 text-sm font-medium text-black shadow-sm"
        >
            {{ successMessage }}
        </div>

        <div
            v-if="errorMessage"
            class="rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-black shadow-sm"
        >
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <span>{{ errorMessage }}</span>
                <button
                    v-if="!loading"
                    type="button"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold transition hover:bg-gray-100"
                    @click="fetchUser"
                >
                    Retry
                </button>
            </div>
        </div>

        <div v-if="loading" class="rounded-lg border border-border bg-surface p-6 shadow-sm">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div v-for="item in 8" :key="item" class="space-y-3">
                    <div class="h-4 w-28 animate-pulse rounded bg-gray-200"></div>
                    <div class="h-11 animate-pulse rounded-lg bg-gray-200"></div>
                </div>
            </div>
        </div>

        <form
            v-else-if="userLoaded"
            class="rounded-lg border border-border bg-surface p-6 shadow-sm"
            @submit.prevent="submitForm"
        >
            <fieldset :disabled="submitting" class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label for="username" class="mb-2 block text-sm font-semibold text-text">Username</label>
                    <input
                        id="username"
                        v-model="form.username"
                        type="text"
                        autocomplete="username"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-black shadow-sm transition focus:border-black focus:outline-none focus:ring-2 focus:ring-black"
                        :class="{ 'border-black': fieldError('username') }"
                    />
                    <p v-if="fieldError('username')" class="mt-2 text-sm text-black">
                        {{ fieldError('username') }}
                    </p>
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-semibold text-text">Email</label>
                    <input
                        id="email"
                        v-model="form.email"
                        type="email"
                        autocomplete="email"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-black shadow-sm transition focus:border-black focus:outline-none focus:ring-2 focus:ring-black"
                        :class="{ 'border-black': fieldError('email') }"
                    />
                    <p v-if="fieldError('email')" class="mt-2 text-sm text-black">
                        {{ fieldError('email') }}
                    </p>
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-semibold text-text">
                        Password
                    </label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        autocomplete="new-password"
                        placeholder="Leave blank to keep current password"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-black shadow-sm transition focus:border-black focus:outline-none focus:ring-2 focus:ring-black"
                        :class="{ 'border-black': fieldError('password') }"
                    />
                    <p v-if="fieldError('password')" class="mt-2 text-sm text-black">
                        {{ fieldError('password') }}
                    </p>
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-text">
                        Confirm Password
                    </label>
                    <input
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        placeholder="Repeat new password"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-black shadow-sm transition focus:border-black focus:outline-none focus:ring-2 focus:ring-black"
                        :class="{ 'border-black': fieldError('password_confirmation') }"
                    />
                    <p v-if="fieldError('password_confirmation')" class="mt-2 text-sm text-black">
                        {{ fieldError('password_confirmation') }}
                    </p>
                </div>

                <div>
                    <label for="role" class="mb-2 block text-sm font-semibold text-text">Role</label>
                    <select
                        id="role"
                        v-model="form.role"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-black shadow-sm transition focus:border-black focus:outline-none focus:ring-2 focus:ring-black"
                        :class="{ 'border-black': fieldError('role') }"
                    >
                        <option v-for="role in roleOptions" :key="role" :value="role">
                            {{ role }}
                        </option>
                    </select>
                    <p v-if="fieldError('role')" class="mt-2 text-sm text-black">
                        {{ fieldError('role') }}
                    </p>
                </div>

                <div>
                    <label for="status" class="mb-2 block text-sm font-semibold text-text">Status</label>
                    <select
                        id="status"
                        v-model="form.status"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-black shadow-sm transition focus:border-black focus:outline-none focus:ring-2 focus:ring-black"
                        :class="{ 'border-black': fieldError('status') }"
                    >
                        <option v-for="status in statusOptions" :key="status" :value="status">
                            {{ status }}
                        </option>
                    </select>
                    <p v-if="fieldError('status')" class="mt-2 text-sm text-black">
                        {{ fieldError('status') }}
                    </p>
                </div>

                <div>
                    <label for="language" class="mb-2 block text-sm font-semibold text-text">Language</label>
                    <select
                        id="language"
                        v-model="form.language"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-black shadow-sm transition focus:border-black focus:outline-none focus:ring-2 focus:ring-black"
                        :class="{ 'border-black': fieldError('language') }"
                    >
                        <option v-for="language in languageOptions" :key="language" :value="language">
                            {{ language }}
                        </option>
                    </select>
                    <p v-if="fieldError('language')" class="mt-2 text-sm text-black">
                        {{ fieldError('language') }}
                    </p>
                </div>

                <div>
                    <label for="timezone" class="mb-2 block text-sm font-semibold text-text">Timezone</label>
                    <select
                        id="timezone"
                        v-model="form.timezone"
                        class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-black shadow-sm transition focus:border-black focus:outline-none focus:ring-2 focus:ring-black"
                        :class="{ 'border-black': fieldError('timezone') }"
                    >
                        <option v-for="timezone in timezoneOptions" :key="timezone" :value="timezone">
                            {{ timezone }}
                        </option>
                    </select>
                    <p v-if="fieldError('timezone')" class="mt-2 text-sm text-black">
                        {{ fieldError('timezone') }}
                    </p>
                </div>
            </fieldset>

            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <router-link
                    :to="{ name: 'Users' }"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-black transition hover:bg-gray-100"
                >
                    Cancel
                </router-link>
                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-lg bg-black px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-60"
                    :disabled="submitting"
                >
                    {{ submitting ? 'Saving...' : 'Save Changes' }}
                </button>
            </div>
        </form>
    </section>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '../../utils/axios';
import {
    emptyUserForm,
    firstError,
    getErrorMessage,
    getValidationErrors,
    getUserName,
    languageOptions,
    roleOptions,
    statusOptions,
    timezoneOptions,
} from './userHelpers';

const route = useRoute();
const router = useRouter();

const userId = route.params.id;
const form = reactive(emptyUserForm());
const loading = ref(true);
const userLoaded = ref(false);
const submitting = ref(false);
const errors = ref({});
const errorMessage = ref('');
const successMessage = ref('');

const fieldError = (field) => firstError(errors.value, field);

const fillForm = (user) => {
    form.username = getUserName(user) === '-' ? '' : getUserName(user);
    form.email = user.email || '';
    form.password = '';
    form.password_confirmation = '';
    form.role = user.role || 'user';
    form.language = user.language || 'en';
    form.timezone = user.timezone || 'UTC';
    form.status = user.status || 'active';
};

const fetchUser = async () => {
    loading.value = true;
    userLoaded.value = false;
    errors.value = {};
    errorMessage.value = '';

    try {
        const response = await api.get(`/users/${userId}`);
        fillForm(response.data?.data || {});
        userLoaded.value = true;
    } catch (error) {
        errorMessage.value = getErrorMessage(error, 'Failed to fetch user.');
    } finally {
        loading.value = false;
    }
};

const buildPayload = () => {
    const payload = {
        username: form.username,
        email: form.email,
        role: form.role,
        language: form.language,
        timezone: form.timezone,
        status: form.status,
    };

    if (form.password) {
        payload.password = form.password;
        payload.password_confirmation = form.password_confirmation;
    }

    return payload;
};

const submitForm = async () => {
    submitting.value = true;
    errors.value = {};
    errorMessage.value = '';
    successMessage.value = '';

    try {
        await api.put(`/users/${userId}`, buildPayload());
        successMessage.value = 'User updated successfully.';
        await new Promise((resolve) => setTimeout(resolve, 500));
        await router.push({ name: 'Users', query: { updated: '1' } });
    } catch (error) {
        errors.value = getValidationErrors(error);
        errorMessage.value = getErrorMessage(error, 'Failed to update user.');
    } finally {
        submitting.value = false;
    }
};

onMounted(fetchUser);
</script>
