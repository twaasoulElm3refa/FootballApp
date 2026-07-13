<template>
    <div class="bg-surface rounded-2xl shadow-sm border border-border p-6">
        <p v-if="loading" class="py-12 text-center text-muted">Loading...</p>
        <p v-else-if="loadError" class="py-12 text-center text-danger">Failed to load league data.</p>

        <template v-else>
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6 mb-8">
                <div class="flex items-center gap-4 min-w-0">
                    <img
                        v-if="league.logo && !logoFailed"
                        :src="league.logo"
                        :alt="league.name || 'League logo'"
                        class="w-20 h-20 rounded-2xl object-contain bg-background border border-border"
                        @error="logoFailed = true"
                    >
                    <div
                        v-else
                        class="w-20 h-20 rounded-2xl bg-primary bg-opacity-10 text-primary text-2xl font-bold flex items-center justify-center shrink-0"
                    >
                        {{ getLeagueInitial(league) }}
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-2xl font-bold text-text truncate">{{ league.name || '-' }}</h1>
                        <p class="text-sm text-muted mt-1">API League ID: {{ formatNumber(league.api_league_id) }}</p>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <button
                        type="button"
                        class="px-4 py-2 rounded-xl border border-border text-text font-medium hover:bg-background transition-colors"
                        @click="router.push({ name: 'Leagues' })"
                    >
                        Back
                    </button>
                    <button
                        type="button"
                        class="px-4 py-2 rounded-xl bg-warning text-white font-medium hover:opacity-90 transition-opacity"
                        @click="router.push({ name: 'EditLeague', params: { id } })"
                    >
                        Edit
                    </button>
                    <button
                        type="button"
                        class="px-4 py-2 rounded-xl bg-danger text-white font-medium hover:opacity-90 disabled:opacity-50 disabled:cursor-not-allowed transition-opacity"
                        :disabled="deleting"
                        @click="handleDelete"
                    >
                        {{ deleting ? 'Deleting...' : 'Delete' }}
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                <div v-for="detail in details" :key="detail.label" class="rounded-xl border border-border p-4">
                    <p class="text-xs uppercase tracking-wide text-muted">{{ detail.label }}</p>
                    <p class="text-sm font-medium text-text mt-2">{{ detail.value }}</p>
                </div>

                <div class="rounded-xl border border-border p-4">
                    <p class="text-xs uppercase tracking-wide text-muted">Country</p>
                    <div class="flex items-center gap-2 mt-2">
                        <img
                            v-if="league.flag"
                            :src="league.flag"
                            :alt="league.country || 'Country flag'"
                            class="w-7 h-5 rounded object-cover"
                            @error="$event.currentTarget.style.display = 'none'"
                        >
                        <span class="text-sm font-medium text-text">{{ league.country || '-' }}</span>
                    </div>
                </div>

                <div v-for="badge in badges" :key="badge.label" class="rounded-xl border border-border p-4">
                    <p class="text-xs uppercase tracking-wide text-muted mb-2">{{ badge.label }}</p>
                    <span :class="['inline-flex px-2.5 py-1 rounded-full text-xs font-medium', badge.class]">
                        {{ badge.text }}
                    </span>
                </div>
            </div>

            <div v-if="league.meta" class="mt-6 rounded-xl border border-border p-4">
                <p class="text-xs uppercase tracking-wide text-muted mb-3">Meta</p>
                <pre class="overflow-x-auto whitespace-pre-wrap break-words text-sm text-text font-mono">{{ formattedMeta }}</pre>
            </div>
        </template>
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { deleteLeague, getLeague } from '../../services/leagues/leagueService';
import { toastError } from '../../utils/toast';
import { formatDate, formatNumber, getBooleanBadge, getLeagueInitial } from './leagueHelpers';

const route = useRoute();
const router = useRouter();
const id = route.params.id;
const loading = ref(true);
const loadError = ref(false);
const deleting = ref(false);
const logoFailed = ref(false);
const league = ref({});

const details = computed(() => [
    { label: 'Type', value: league.value.type || '-' },
    { label: 'Season', value: league.value.season ?? '-' },
    { label: 'Sort Order', value: formatNumber(league.value.sort_order) },
    { label: 'Created At', value: formatDate(league.value.created_at) },
    { label: 'Updated At', value: formatDate(league.value.updated_at) },
]);

const badges = computed(() => [
    { label: 'Status', ...getBooleanBadge(league.value.is_active, 'Active', 'Inactive') },
    { label: 'Featured', ...getBooleanBadge(league.value.is_featured, 'Featured', 'Normal', 'warning') },
    { label: 'Has Standings', ...getBooleanBadge(league.value.has_standings, 'Yes', 'No') },
]);

const formattedMeta = computed(() => {
    if (!league.value.meta) {
        return '';
    }

    return typeof league.value.meta === 'string'
        ? league.value.meta
        : JSON.stringify(league.value.meta, null, 2);
});

const fetchLeague = async () => {
    loading.value = true;
    loadError.value = false;

    try {
        const result = await getLeague(id);

        if (!result.id) {
            throw new Error('League not found.');
        }

        league.value = result;
    } catch (error) {
        loadError.value = true;
        toastError('Failed to load league data.');
    } finally {
        loading.value = false;
    }
};

const handleDelete = async () => {
    if (!window.confirm('Are you sure you want to delete this league?')) {
        return;
    }

    deleting.value = true;

    try {
        await deleteLeague(id);
        await router.push({ name: 'Leagues' });
    } catch (error) {
        if (!error.__toastShown) {
            toastError('Failed to delete league. Please try again.');
        }
    } finally {
        deleting.value = false;
    }
};

onMounted(fetchLeague);
</script>
