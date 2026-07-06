<template>
    <section class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-muted">Users</p>
                <h1 class="mt-1 text-3xl font-bold text-text">Show User</h1>
                <p class="mt-2 text-sm text-muted">Review account profile and activity details.</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <router-link
                    :to="{ name: 'Users' }"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-semibold text-black shadow-sm transition hover:bg-gray-100"
                >
                    Back
                </router-link>
                <router-link
                    :to="{ name: 'EditUser', params: { id: userId } }"
                    class="inline-flex items-center justify-center rounded-lg bg-black px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800"
                >
                    Edit User
                </router-link>
            </div>
        </div>

        <div
            v-if="errorMessage"
            class="rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm text-black shadow-sm"
        >
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <span>{{ errorMessage }}</span>
                <button
                    type="button"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold transition hover:bg-gray-100"
                    @click="fetchUser"
                >
                    Retry
                </button>
            </div>
        </div>

        <div v-if="loading" class="rounded-lg border border-border bg-surface p-6 shadow-sm">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                <div v-for="item in 12" :key="item" class="rounded-lg border border-gray-200 p-4">
                    <div class="h-4 w-24 animate-pulse rounded bg-gray-200"></div>
                    <div class="mt-3 h-5 w-40 animate-pulse rounded bg-gray-200"></div>
                </div>
            </div>
        </div>

        <div v-else-if="user.id" class="rounded-lg border border-border bg-surface p-6 shadow-sm">
            <div class="mb-6 flex flex-col gap-2 border-b border-border pb-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-text">{{ getUserName(user) }}</h2>
                    <p class="mt-1 text-sm text-muted">{{ user.email || '-' }}</p>
                </div>

                <span
                    class="inline-flex w-fit rounded-full px-3 py-1 text-xs font-semibold"
                    :class="statusClass(user.status)"
                >
                    {{ user.status || '-' }}
                </span>
            </div>

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3">
                <div
                    v-for="field in detailFields"
                    :key="field.label"
                    class="rounded-lg border border-gray-200 bg-white p-4"
                >
                    <p class="text-xs font-semibold uppercase tracking-wide text-muted">
                        {{ field.label }}
                    </p>
                    <p class="mt-2 break-words text-sm font-semibold text-text">
                        {{ field.value }}
                    </p>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import api from '../../utils/axios';
import { formatDate, getErrorMessage, getUserName } from './userHelpers';

const route = useRoute();
const userId = route.params.id;

const user = ref({});
const loading = ref(true);
const errorMessage = ref('');

const detailFields = computed(() => [
    { label: 'ID', value: user.value?.id || '-' },
    { label: 'UUID', value: user.value?.uuid || '-' },
    { label: 'Username', value: getUserName(user.value) },
    { label: 'Email', value: user.value?.email || '-' },
    { label: 'Role', value: user.value?.role || '-' },
    { label: 'Language', value: user.value?.language || '-' },
    { label: 'Timezone', value: user.value?.timezone || '-' },
    { label: 'Status', value: user.value?.status || '-' },
    { label: 'Email Verified At', value: formatDate(user.value?.email_verified_at) },
    { label: 'Phone Verified At', value: formatDate(user.value?.phone_verified_at) },
    { label: 'Last Login At', value: formatDate(user.value?.last_login_at) },
    { label: 'Last Seen At', value: formatDate(user.value?.last_seen_at) },
    { label: 'Created At', value: formatDate(user.value?.created_at) },
    { label: 'Updated At', value: formatDate(user.value?.updated_at) },
]);

const statusClass = (status) => {
    if (status === 'active') {
        return 'bg-black text-white';
    }

    if (status === 'deleted') {
        return 'bg-gray-200 text-gray-700';
    }

    return 'bg-gray-100 text-gray-900';
};

const fetchUser = async () => {
    loading.value = true;
    errorMessage.value = '';

    try {
        const response = await api.get(`/users/${userId}`);
        user.value = response.data?.data || {};
    } catch (error) {
        user.value = {};
        errorMessage.value = getErrorMessage(error, 'Failed to fetch user.');
    } finally {
        loading.value = false;
    }
};

onMounted(fetchUser);
</script>
