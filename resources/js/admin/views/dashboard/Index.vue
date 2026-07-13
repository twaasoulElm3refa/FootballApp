<template>
    <div>
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-text mb-2">
                Welcome back, {{ authStore.user?.username || 'Admin' }}!
            </h1>
            <p class="text-muted">Here is what's happening with your platform today.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-8">
            <div v-for="card in dashboardCards" :key="card.title"
                class="bg-surface rounded-2xl p-6 shadow-sm border border-border transition-transform hover:-translate-y-1 duration-300">
                <div class="flex justify-between items-start gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-muted mb-1">{{ card.title }}</p>
                        <h3 class="text-2xl font-bold text-text">
                            {{ dashboardLoading ? '...' : formatNumber(card.value) }}
                        </h3>
                    </div>
                    <div :class="['p-3 rounded-xl shrink-0', getIconClass(card.color)]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="card.icon" />
                        </svg>
                    </div>
                </div>
                <p class="mt-4 text-sm text-muted">Live platform count</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            <!-- Latest Users -->
            <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 min-h-[360px]">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-bold text-text">Latest Users</h3>

                    <button type="button" class="text-sm font-medium text-primary hover:underline"
                        @click="fetchDashboardData">
                        Refresh
                    </button>
                </div>

                <div v-if="dashboardLoading" class="text-sm text-muted">
                    Loading users...
                </div>

                <div v-else-if="!latestUsers.length" class="text-sm text-muted">
                    No latest users found.
                </div>

                <div v-else class="flex flex-col space-y-4">
                    <div v-for="user in latestUsers" :key="user.id"
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-border last:border-0 last:pb-0">
                        <div class="flex items-start gap-4 min-w-0">
                            <div
                                class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-white font-bold shrink-0">
                                {{ getUserInitial(user) }}
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-bold text-text truncate">
                                    {{ user.username || 'Unknown User' }}
                                </p>

                                <p class="text-xs text-muted truncate">
                                    {{ user.email || '-' }}
                                </p>

                                <div class="flex items-center gap-2 mt-1 text-xs text-muted">
                                    <span class="capitalize">{{ user.role || '-' }}</span>
                                    <span>•</span>
                                    <span>{{ formatDate(user.last_login_at || user.created_at) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 sm:justify-end flex-wrap">
                            <span class="px-3 py-1 rounded-full text font-bold capitalize">
                                {{ user.status || 'unknown' }}
                            </span>

                            <button type="button"
                                class="px-3 py-1.5 rounded-full text-xs font-bold border border-primary text-primary hover:bg-primary hover:text-white transition-colors"
                                @click="handleShowUser(user)">
                                Show
                            </button>

                            <button type="button"
                                class="px-3 py-1.5 rounded-full text-xs font-bold border border-warning text-warning hover:bg-warning hover:text-white transition-colors"
                                @click="handleEditUser(user)">
                                Edit
                            </button>

                            <button type="button"
                                class="px-3 py-1.5 rounded-full text-xs font-bold bg-danger text-white hover:opacity-90 transition-opacity disabled:opacity-60"
                                :disabled="deletingUserId === user.id" @click="handleDeleteUser(user)">
                                {{ deletingUserId === user.id ? 'Deleting...' : 'Delete' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 min-h-[360px]">
                <div class="flex items-center justify-between gap-4 mb-5">
                    <div>
                        <h3 class="text-lg font-bold text-text">Top Leagues</h3>
                        <p class="text-sm text-muted mt-1">Top active leagues by sort order</p>
                    </div>

                    <button
                        type="button"
                        class="text-sm font-medium text-primary hover:underline disabled:opacity-60"
                        :disabled="topLeaguesLoading"
                        @click="fetchTopLeagues"
                    >
                        {{ topLeaguesLoading ? 'Loading...' : 'Refresh' }}
                    </button>
                </div>

                <div v-if="topLeaguesLoading" class="text-sm text-muted">
                    Loading leagues...
                </div>

                <div
                    v-else-if="!topLeagues.length"
                    class="h-[260px] flex items-center justify-center text-center text-muted"
                >
                    <div>
                        <div
                            class="w-12 h-12 rounded-2xl bg-background flex items-center justify-center mx-auto mb-3 text-primary">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 21h8M12 17v4M7 4h10v4a5 5 0 01-10 0V4zM5 4H3v3a3 3 0 003 3M19 4h2v3a3 3 0 01-3 3" />
                            </svg>
                        </div>

                        <p class="text-sm font-medium">No top leagues found.</p>
                    </div>
                </div>

                <div v-else class="flex flex-col space-y-4">
                    <div
                        v-for="league in topLeagues"
                        :key="league.id"
                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-border last:border-0 last:pb-0"
                    >
                        <div class="flex items-center gap-4 min-w-0">
                            <div
                                class="w-11 h-11 rounded-full bg-background flex items-center justify-center overflow-hidden shrink-0 border border-border"
                            >
                                <img
                                    v-if="league.logo && !failedTopLeagueLogos.has(league.id)"
                                    :src="league.logo"
                                    :alt="league.name || 'League logo'"
                                    class="w-full h-full object-contain p-1"
                                    loading="lazy"
                                    @error="markTopLeagueLogoAsFailed(league.id)"
                                >
                                <span v-else class="text-primary font-bold">
                                    {{ getLeagueInitial(league) }}
                                </span>
                            </div>

                            <div class="min-w-0">
                                <p class="text-sm font-bold text-text truncate">
                                    {{ league.name || 'Unknown League' }}
                                </p>

                                <div class="flex items-center gap-2 mt-1 text-xs text-muted">
                                    <img
                                        v-if="league.flag"
                                        :src="league.flag"
                                        :alt="league.country || 'Country flag'"
                                        class="w-4 h-4 rounded-full object-cover"
                                        loading="lazy"
                                        @error="$event.currentTarget.style.display = 'none'"
                                    >
                                    <span class="truncate">{{ league.country || '-' }}</span>
                                    <span>&bull;</span>
                                    <span>{{ league.season || '-' }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 shrink-0 flex-wrap sm:justify-end">
                            <span
                                v-if="league.is_featured"
                                class="px-2.5 py-1 rounded-full text font-bold bg-opacity-10 text-warning"
                            >
                                Featured
                            </span>

                            <span
                                class="px-2.5 py-1 rounded-full text font-bold"
                            >
                                {{ league.is_active ? 'Active' : 'Inactive' }}
                            </span>

                            <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-background text-muted">
                                #{{ league.sort_order ?? 0 }}
                            </span>

                            <button
                                type="button"
                                class="px-3 py-1.5 rounded-full text-xs font-bold border border-primary text-primary hover:bg-primary hover:text-white transition-colors"
                                @click="handleShowLeague(league)"
                            >
                                View
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../../store/auth';
import {
    deleteUser,
    getActiveUsersCount,
    getFinishedFixturesCount,
    getFixturesCount,
    getLatestUsers,
    getLeaguesCount,
    getTeamsCount,
    getUsersCount,
} from '../../services/dashboard/dashboardService';
import { getTopLeagues } from '../../services/leagues/leagueService';
import { toastError } from '../../utils/toast';

const router = useRouter();
const authStore = useAuthStore();

const dashboardLoading = ref(true);
const deletingUserId = ref(null);
const counts = ref({
    users: 0,
    activeUsers: 0,
    leagues: 0,
    teams: 0,
    fixtures: 0,
    finishedFixtures: 0,
});
const latestUsers = ref([]);
const topLeagues = ref([]);
const topLeaguesLoading = ref(false);
const failedTopLeagueLogos = ref(new Set());

const dashboardCards = computed(() => [
    {
        title: 'Total Users',
        value: counts.value.users,
        color: 'primary',
        icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
    },
    {
        title: 'Active Users',
        value: counts.value.activeUsers,
        color: 'success',
        icon: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
    },
    {
        title: 'Leagues',
        value: counts.value.leagues,
        color: 'secondary',
        icon: 'M8 21h8m-4-4v4M7 4h10v5a5 5 0 01-10 0V4zm0 2H4v2a4 4 0 004 4m9-6h3v2a4 4 0 01-4 4',
    },
    {
        title: 'Teams',
        value: counts.value.teams,
        color: 'warning',
        icon: 'M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m7-10a4 4 0 100-8 4 4 0 000 8zm13 10v-2a4 4 0 00-3-3.87m-2-9.26a4 4 0 010 7.75',
    },
    {
        title: 'Fixtures',
        value: counts.value.fixtures,
        color: 'primary',
        icon: 'M8 7V3m8 4V3M5 11h14M5 5h14a2 2 0 012 2v12a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z',
    },
    {
        title: 'Finished Fixtures',
        value: counts.value.finishedFixtures,
        color: 'success',
        icon: 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
    },
]);

const fetchDashboardData = async () => {
    dashboardLoading.value = true;

    try {
        const [
            usersCountResult,
            activeUsersResult,
            leaguesResult,
            teamsResult,
            fixturesResult,
            finishedFixturesResult,
            latestUsersResult,
        ] = await Promise.allSettled([
            getUsersCount(),
            getActiveUsersCount(),
            getLeaguesCount(),
            getTeamsCount(),
            getFixturesCount(),
            getFinishedFixturesCount(),
            getLatestUsers(),
        ]);

        counts.value.users = usersCountResult.status === 'fulfilled' ? usersCountResult.value : 0;
        counts.value.activeUsers = activeUsersResult.status === 'fulfilled' ? activeUsersResult.value : 0;
        counts.value.leagues = leaguesResult.status === 'fulfilled' ? leaguesResult.value : 0;
        counts.value.teams = teamsResult.status === 'fulfilled' ? teamsResult.value : 0;
        counts.value.fixtures = fixturesResult.status === 'fulfilled' ? fixturesResult.value : 0;
        counts.value.finishedFixtures = finishedFixturesResult.status === 'fulfilled'
            ? finishedFixturesResult.value
            : 0;
        latestUsers.value = latestUsersResult.status === 'fulfilled'
            ? latestUsersResult.value.slice(0, 10)
            : [];
    } finally {
        dashboardLoading.value = false;
    }
};

const fetchTopLeagues = async () => {
    topLeaguesLoading.value = true;

    try {
        const leagues = await getTopLeagues();
        topLeagues.value = leagues.slice(0, 5);
    } catch (error) {
        topLeagues.value = [];
    } finally {
        topLeaguesLoading.value = false;
    }
};

const formatNumber = (value) => {
    if (value === null || value === undefined) {
        return '0';
    }

    return new Intl.NumberFormat().format(Number(value) || 0);
};

const formatDate = (date) => {
    if (!date) {
        return '-';
    }

    const parsedDate = new Date(date);

    if (Number.isNaN(parsedDate.getTime())) {
        return '-';
    }

    return new Intl.DateTimeFormat(undefined, {
        dateStyle: 'short',
        timeStyle: 'short',
    }).format(parsedDate);
};

const getUserInitial = (user) => {
    return (user?.username?.trim()?.[0] || user?.email?.trim()?.[0] || 'U').toUpperCase();
};

const getLeagueInitial = (league) => {
    return String(league?.name || 'L').charAt(0).toUpperCase();
};

const markTopLeagueLogoAsFailed = (id) => {
    failedTopLeagueLogos.value = new Set([...failedTopLeagueLogos.value, id]);
};

const getStatusClass = (status) => {
    return status === 'active'
        ? 'bg-success bg-opacity-10 text-success'
        : 'bg-danger bg-opacity-10 text-danger';
};

const getIconClass = (color) => {
    const classes = {
        primary: 'bg-primary bg-opacity-10 text-primary',
        secondary: 'bg-secondary bg-opacity-10 text-secondary',
        success: 'bg-success bg-opacity-10 text-success',
        warning: 'bg-warning bg-opacity-10 text-warning',
        danger: 'bg-danger bg-opacity-10 text-danger',
    };

    return classes[color] || classes.primary;
};

const handleShowUser = (user) => {
    router.push({ name: 'ShowUser', params: { id: user.uuid } });
};


const handleEditUser = (user) => {
    router.push({ name: 'EditUser', params: { id: user.uuid } });
};

const handleShowLeague = (league) => {
    if (!league?.id) {
        return;
    }

    router.push({ name: 'ShowLeague', params: { id: league.id } });
};

const handleDeleteUser = async (user) => {
    if (!window.confirm('Are you sure you want to delete this user?')) {
        return;
    }

    deletingUserId.value = user.id;

    try {
        await deleteUser(user.id);
        latestUsers.value = latestUsers.value.filter((latestUser) => latestUser.id !== user.id);
        counts.value.users = Math.max(0, counts.value.users - 1);

        if (user.status === 'active') {
            counts.value.activeUsers = Math.max(0, counts.value.activeUsers - 1);
        }
    } catch (error) {
        if (!error.__toastShown) {
            toastError('Failed to delete user. Please try again.');
        }
    } finally {
        deletingUserId.value = null;
    }
};

onMounted(() => {
    fetchDashboardData();
    fetchTopLeagues();
});
</script>
