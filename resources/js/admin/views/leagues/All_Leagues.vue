<template>
    <div class="bg-surface rounded-2xl shadow-sm border border-border p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-text">Leagues</h1>
                <p class="text-sm text-muted mt-1">Manage the football leagues available on the platform.</p>
            </div>
            <button
                type="button"
                class="px-5 py-2.5 rounded-xl bg-primary text-white font-medium hover:opacity-90 transition-opacity"
                @click="router.push({ name: 'CreateLeague' })"
            >
                Create League
            </button>
        </div>

        <p v-if="loading" class="py-12 text-center text-muted">Loading...</p>
        <p v-else-if="loadError" class="py-12 text-center text-danger">Failed to load league data.</p>
        <p v-else-if="leagues.length === 0" class="py-12 text-center text-muted">No leagues found.</p>

        <template v-else>
            <div class="overflow-x-auto">
                <table class="w-full min-w-[1250px] text-left">
                    <thead>
                        <tr class="border-b border-border text-xs uppercase tracking-wide text-muted">
                            <th class="px-3 py-4 font-semibold">Logo</th>
                            <th class="px-3 py-4 font-semibold">Name</th>
                            <!-- <th class="px-3 py-4 font-semibold">API League ID</th> -->
                            <th class="px-3 py-4 font-semibold">Type</th>
                            <th class="px-3 py-4 font-semibold">Country</th>
                            <th class="px-3 py-4 font-semibold">Season</th>
                            <th class="px-3 py-4 font-semibold">Active</th>
                            <th class="px-3 py-4 font-semibold">Featured</th>
                            <th class="px-3 py-4 font-semibold">Standings</th>
                            <th class="px-3 py-4 font-semibold">Sort Order</th>
                            <th class="px-3 py-4 font-semibold text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="league in leagues"
                            :key="league.id"
                            class="border-b border-border last:border-0"
                        >
                            <td class="px-3 py-4">
                                <img
                                    v-if="league.logo && !failedLogos.has(league.id)"
                                    :src="league.logo"
                                    :alt="league.name || 'League logo'"
                                    class="w-10 h-10 rounded-full object-contain bg-background"
                                    @error="markLogoAsFailed(league.id)"
                                >
                                <span
                                    v-else
                                    class="w-10 h-10 rounded-full bg-primary bg-opacity-10 text-primary font-bold flex items-center justify-center"
                                >
                                    {{ getLeagueInitial(league) }}
                                </span>
                            </td>
                            <td class="px-3 py-4 font-medium text-text">{{ league.name || '-' }}</td>
                            <!-- <td class="px-3 py-4 text-muted">{{ formatNumber(league.api_league_id) }}</td> -->
                            <td class="px-3 py-4 text-muted">{{ league.type || '-' }}</td>
                            <td class="px-3 py-4">
                                <div class="flex items-center gap-2 text-muted">
                                    <img
                                        v-if="league.flag"
                                        :src="league.flag"
                                        :alt="league.country || 'Country flag'"
                                        class="w-6 h-4 rounded object-cover"
                                        @error="$event.currentTarget.style.display = 'none'"
                                    >
                                    <span>{{ league.country || '-' }}</span>
                                </div>
                            </td>
                            <td class="px-3 py-4 text-muted">{{ league.season ?? '-' }}</td>
                            <td class="px-3 py-4">
                                <span :class="['px-2.5 py-1 rounded-full text-xs font-medium', activeBadge(league).class]">
                                    {{ activeBadge(league).text }}
                                </span>
                            </td>
                            <td class="px-3 py-4">
                                <span :class="['px-2.5 py-1 rounded-full text-xs font-medium', featuredBadge(league).class]">
                                    {{ featuredBadge(league).text }}
                                </span>
                            </td>
                            <td class="px-3 py-4">
                                <span :class="['px-2.5 py-1 rounded-full text-xs font-medium', standingsBadge(league).class]">
                                    {{ standingsBadge(league).text }}
                                </span>
                            </td>
                            <td class="px-3 py-4 text-muted">{{ formatNumber(league.sort_order) }}</td>
                            <td class="px-3 py-4">
                                <div class="flex justify-end gap-2">
                                    <button
                                        type="button"
                                        class="px-3 py-1.5 rounded-lg border border-primary text-primary text-sm hover:bg-primary hover:text-white transition-colors"
                                        @click="showLeague(league)"
                                    >
                                        Show
                                    </button>
                                    <button
                                        type="button"
                                        class="px-3 py-1.5 rounded-lg border border-warning text-warning text-sm hover:bg-warning hover:text-white transition-colors"
                                        @click="editLeague(league)"
                                    >
                                        Edit
                                    </button>
                                    <button
                                        type="button"
                                        class="px-3 py-1.5 rounded-lg bg-danger text-white text-sm hover:opacity-90 disabled:opacity-50 disabled:cursor-not-allowed transition-opacity"
                                        :disabled="deletingLeagueId === league.id"
                                        @click="handleDeleteLeague(league)"
                                    >
                                        {{ deletingLeagueId === league.id ? 'Deleting...' : 'Delete' }}
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mt-6 pt-6 border-t border-border">
                <p class="text-sm text-muted">
                    Showing {{ pagination.from ?? 0 }} to {{ pagination.to ?? 0 }} of
                    {{ formatNumber(pagination.total) }}
                </p>
                <div class="flex flex-wrap items-center gap-2">
                    <button
                        type="button"
                        class="px-3 py-2 rounded-lg border border-border text-sm text-text disabled:opacity-40 disabled:cursor-not-allowed"
                        :disabled="pagination.currentPage <= 1 || loading"
                        @click="goToPage(pagination.currentPage - 1)"
                    >
                        Previous
                    </button>
                    <button
                        v-for="link in pageLinks"
                        :key="link.page"
                        type="button"
                        :class="[
                            'min-w-10 px-3 py-2 rounded-lg border text-sm transition-colors',
                            link.active
                                ? 'bg-primary border-primary text-white'
                                : 'border-border text-text hover:border-primary hover:text-primary',
                        ]"
                        :disabled="loading"
                        @click="goToPage(link.page)"
                    >
                        {{ link.page }}
                    </button>
                    <button
                        type="button"
                        class="px-3 py-2 rounded-lg border border-border text-sm text-text disabled:opacity-40 disabled:cursor-not-allowed"
                        :disabled="pagination.currentPage >= pagination.lastPage || loading"
                        @click="goToPage(pagination.currentPage + 1)"
                    >
                        Next
                    </button>
                </div>
            </div>
        </template>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { deleteLeague, getLeagues } from '../../services/leagues/leagueService';
import { toastError } from '../../utils/toast';
import { formatNumber, getBooleanBadge, getLeagueInitial } from './leagueHelpers';

const router = useRouter();
const loading = ref(true);
const loadError = ref(false);
const deletingLeagueId = ref(null);
const leagues = ref([]);
const failedLogos = ref(new Set());
const pagination = ref({
    currentPage: 1,
    lastPage: 1,
    perPage: 10,
    total: 0,
    from: null,
    to: null,
    links: [],
});

const pageLinks = computed(() => pagination.value.links.filter((link) => {
    return link.page !== null && Number.isFinite(Number(link.page));
}));

const fetchLeagues = async () => {
    loading.value = true;
    loadError.value = false;

    try {
        const result = await getLeagues({ page: pagination.value.currentPage });
        leagues.value = result.items;
        pagination.value = result;
    } catch (error) {
        leagues.value = [];
        loadError.value = true;
        toastError('Failed to load league data.');
    } finally {
        loading.value = false;
    }
};

const goToPage = (page) => {
    const normalizedPage = Number(page);

    if (
        !Number.isInteger(normalizedPage)
        || normalizedPage < 1
        || normalizedPage > pagination.value.lastPage
        || normalizedPage === pagination.value.currentPage
    ) {
        return;
    }

    pagination.value.currentPage = normalizedPage;
    fetchLeagues();
};

const markLogoAsFailed = (id) => {
    failedLogos.value = new Set([...failedLogos.value, id]);
};

const activeBadge = (league) => getBooleanBadge(league.is_active, 'Active', 'Inactive');
const featuredBadge = (league) => getBooleanBadge(league.is_featured, 'Featured', 'Normal', 'warning');
const standingsBadge = (league) => getBooleanBadge(league.has_standings, 'Yes', 'No');

const showLeague = (league) => {
    router.push({ name: 'ShowLeague', params: { id: league.id } });
};

const editLeague = (league) => {
    router.push({ name: 'EditLeague', params: { id: league.id } });
};

const handleDeleteLeague = async (league) => {
    if (!window.confirm('Are you sure you want to delete this league?')) {
        return;
    }

    deletingLeagueId.value = league.id;

    try {
        await deleteLeague(league.id);

        if (leagues.value.length === 1 && pagination.value.currentPage > 1) {
            pagination.value.currentPage -= 1;
        }

        await fetchLeagues();
    } catch (error) {
        if (!error.__toastShown) {
            toastError('Failed to delete league. Please try again.');
        }
    } finally {
        deletingLeagueId.value = null;
    }
};

onMounted(fetchLeagues);
</script>
