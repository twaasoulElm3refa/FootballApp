<template>
    <section class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-muted">Users</p>
                <h1 class="mt-1 text-3xl font-bold text-text">Create User</h1>
                <p class="mt-2 text-sm text-muted">Add a new user account to the admin API.</p>
            </div>

            <router-link
                :to="{ name: 'Users' }"
                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-black shadow-sm transition hover:bg-gray-100"
            >
                Back
            </router-link>
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
            {{ errorMessage }}
        </div>

        <form
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
                    <label for="password" class="mb-2 block text-sm font-semibold text-text">Password</label>
                    <input
                        id="password"
                        v-model="form.password"
                        type="password"
                        autocomplete="new-password"
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
                    {{ submitting ? 'Creating...' : 'Create User' }}
                </button>
            </div>
        </form>
    </section>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../../utils/axios';
import {
    emptyUserForm,
    firstError,
    getErrorMessage,
    getValidationErrors,
    languageOptions,
    roleOptions,
    statusOptions,
    timezoneOptions,
} from './userHelpers';

const router = useRouter();

const form = reactive(emptyUserForm());
const submitting = ref(false);
const errors = ref({});
const errorMessage = ref('');
const successMessage = ref('');

const fieldError = (field) => firstError(errors.value, field);

const submitForm = async () => {
    submitting.value = true;
    errors.value = {};
    errorMessage.value = '';
    successMessage.value = '';

    try {
        await api.post('/users', form);
        successMessage.value = 'User created successfully.';
        await new Promise((resolve) => setTimeout(resolve, 500));
        await router.push({ name: 'Users', query: { created: '1' } });
    } catch (error) {
        errors.value = getValidationErrors(error);
        errorMessage.value = getErrorMessage(error, 'Failed to create user.');
    } finally {
        submitting.value = false;
    }
};
</script>
