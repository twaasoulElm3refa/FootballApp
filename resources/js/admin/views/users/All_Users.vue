<template>
    <section class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-medium uppercase tracking-wide text-muted">Users</p>
                <h1 class="mt-1 text-3xl font-bold text-text">All Users</h1>
                <p class="mt-2 text-sm text-muted">Manage admin and app users from one place.</p>
            </div>

            <router-link
                :to="{ name: 'CreateUser' }"
                class="inline-flex items-center justify-center rounded-lg bg-black px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2"
            >
                Create User
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
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <span>{{ errorMessage }}</span>
                <button
                    type="button"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold transition hover:bg-gray-100"
                    @click="fetchUsers(pagination.current_page)"
                >
                    Retry
                </button>
            </div>
        </div>

        <div class="overflow-hidden rounded-lg border border-border bg-surface shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                v-for="heading in tableHeadings"
                                :key="heading"
                                class="whitespace-nowrap px-5 py-4 text-left text-xs font-semibold uppercase tracking-wide text-muted"
                            >
                                {{ heading }}
                            </th>
                        </tr>
                    </thead>

                    <tbody v-if="loading" class="divide-y divide-border bg-white">
                        <tr v-for="row in 5" :key="row">
                            <td
                                v-for="column in tableHeadings.length"
                                :key="column"
                                class="px-5 py-4"
                            >
                                <div class="h-4 w-24 animate-pulse rounded bg-gray-200"></div>
                            </td>
                        </tr>
                    </tbody>

                    <tbody v-else-if="users.length" class="divide-y divide-border bg-white">
                        <tr
                            v-for="user in users"
                            :key="user.uuid"
                            class="transition hover:bg-gray-50"
                        >
                            <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-text">
                                {{ user.id }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-text">
                                {{ getUserName(user) }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-muted">
                                {{ user.email || '-' }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-text">
                                {{ user.role || '-' }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-text">
                                {{ user.language || '-' }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-text">
                                {{ user.timezone || '-' }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm">
                                <span
                                    class="inline-flex rounded-full px-3 py-1 text-xs font-semibold"
                                    :class="statusClass(user.status)"
                                >
                                    {{ user.status || '-' }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-muted">
                                {{ formatDate(user.last_login_at) }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm text-muted">
                                {{ formatDate(user.created_at) }}
                            </td>
                            <td class="whitespace-nowrap px-5 py-4 text-sm">
                                <div class="flex flex-wrap items-center gap-2">
                                    <router-link
                                        :to="{ name: 'ShowUser', params: { id: user.uuid } }"
                                        class="rounded-lg border border-gray-300 px-3 py-2 font-medium text-black transition hover:bg-gray-100"
                                    >
                                        View
                                    </router-link>
                                    <router-link
                                        :to="{ name: 'EditUser', params: { id: user.uuid } }"
                                        class="rounded-lg border border-gray-300 px-3 py-2 font-medium text-black transition hover:bg-gray-100"
                                    >
                                        Edit
                                    </router-link>
                                    <button
                                        type="button"
                                        class="rounded-lg bg-black px-3 py-2 font-medium text-white transition hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-60"
                                        :disabled="deletingId === user.id"
                                        @click="deleteUser(user)"
                                    >
                                        {{ deletingId === user.uuid ? 'Deleting...' : 'Delete' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                    <tbody v-else class="bg-white">
                        <tr>
                            <td :colspan="tableHeadings.length" class="px-5 py-16 text-center">
                                <h2 class="text-lg font-semibold text-text">No users found</h2>
                                <p class="mt-2 text-sm text-muted">New users will appear here after they are created.</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                class="flex flex-col gap-4 border-t border-border bg-white px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
            >
                <p class="text-sm text-muted">
                    Showing
                    <span class="font-semibold text-text">{{ pagination.from || 0 }}</span>
                    to
                    <span class="font-semibold text-text">{{ pagination.to || 0 }}</span>
                    of
                    <span class="font-semibold text-text">{{ pagination.total || 0 }}</span>
                    users
                </p>

                <div class="flex flex-wrap items-center gap-2">
                    <button
                        type="button"
                        class="rounded-lg border border-gray-300 px-3 py-2 text-sm font-semibold transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="loading || !pagination.prev_page_url"
                        @click="goToPage(pagination.current_page - 1)"
                    >
                        Previous
                    </button>

                    <button
                        v-for="page in pageNumbers"
                        :key="page"
                        type="button"
                        class="h-9 min-w-9 rounded-lg border px-3 text-sm font-semibold transition"
                        :class="page === pagination.current_page
                            ? 'border-black bg-black text-white'
                            : 'border-gray-300 text-black hover:bg-gray-100'"
                        :disabled="loading"
                        @click="goToPage(page)"
                    >
                        {{ page }}
                    </button>

                    <button
                        type="button"
                        class="rounded-lg border border-gray-300 px-3 py-2 text-sm font-semibold transition hover:bg-gray-100 disabled:cursor-not-allowed disabled:opacity-50"
                        :disabled="loading || !pagination.next_page_url"
                        @click="goToPage(pagination.current_page + 1)"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '../../utils/axios';
import { formatDate, getErrorMessage, getUserName } from './userHelpers';

const route = useRoute();
const router = useRouter();

const tableHeadings = [
    'ID',
    'Username',
    'Email',
    'Role',
    'Language',
    'Timezone',
    'Status',
    'Last Login',
    'Created At',
    'Actions',
];

const defaultPagination = {
    current_page: 1,
    last_page: 1,
    total: 0,
    per_page: 10,
    from: 0,
    to: 0,
    next_page_url: null,
    prev_page_url: null,
};

const users = ref([]);
const pagination = ref({ ...defaultPagination });
const loading = ref(false);
const deletingId = ref(null);
const errorMessage = ref('');
const successMessage = ref('');

const pageNumbers = computed(() => {
    const current = pagination.value.current_page || 1;
    const last = pagination.value.last_page || 1;
    const end = Math.min(last, Math.max(5, current + 2));
    const start = Math.max(1, Math.min(current - 2, end - 4));

    return Array.from({ length: end - start + 1 }, (_, index) => start + index);
});

const statusClass = (status) => {
    if (status === 'active') {
        return 'bg-black text-white';
    }

    if (status === 'deleted') {
        return 'bg-gray-200 text-gray-700';
    }

    return 'bg-gray-100 text-gray-900';
};

const fetchUsers = async (page = 1) => {
    loading.value = true;
    errorMessage.value = '';

    try {
        const response = await api.get('/users', {
            params: { page },
        });
        const paginator = response.data?.data || {};

        users.value = paginator.data || [];
        pagination.value = {
            ...defaultPagination,
            ...paginator,
            current_page: paginator.current_page || page,
        };
    } catch (error) {
        users.value = [];
        pagination.value = { ...defaultPagination };
        errorMessage.value = getErrorMessage(error, 'Failed to fetch users.');
    } finally {
        loading.value = false;
    }
};

const goToPage = (page) => {
    if (loading.value || page < 1 || page > pagination.value.last_page) {
        return;
    }

    fetchUsers(page);
};

const deleteUser = async (user) => {
    const confirmed = window.confirm(`Delete ${getUserName(user)}?`);

    if (!confirmed) {
        return;
    }

    deletingId.value = user.id;
    errorMessage.value = '';
    successMessage.value = '';

    try {
        await api.delete(`/users/${user.id}`);
        successMessage.value = 'User deleted successfully.';

        const nextPage = users.value.length === 1 && pagination.value.current_page > 1
            ? pagination.value.current_page - 1
            : pagination.value.current_page;

        await fetchUsers(nextPage);
    } catch (error) {
        errorMessage.value = getErrorMessage(error, 'Failed to delete user.');
    } finally {
        deletingId.value = null;
    }
};

onMounted(async () => {
    if (route.query.created === '1') {
        successMessage.value = 'User created successfully.';
        await router.replace({ name: 'Users' });
    }

    if (route.query.updated === '1') {
        successMessage.value = 'User updated successfully.';
        await router.replace({ name: 'Users' });
    }

    await fetchUsers(Number(route.query.page) || 1);
});
</script>
