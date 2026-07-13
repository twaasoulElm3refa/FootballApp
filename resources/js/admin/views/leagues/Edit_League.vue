<template>
    <div class="bg-surface rounded-2xl shadow-sm border border-border p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-text">Edit League</h1>
            <p class="text-sm text-muted mt-1">Update this league's platform details.</p>
        </div>

        <p v-if="loading" class="py-12 text-center text-muted">Loading...</p>
        <p v-else-if="loadError" class="py-12 text-center text-danger">Failed to load league data.</p>
        <LeagueForm
            v-else
            v-model="form"
            submit-label="Update League"
            :submitting="submitting"
            @submit="handleSubmit"
            @cancel="router.push({ name: 'ShowLeague', params: { id } })"
        />
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { getLeague, updateLeague } from '../../services/leagues/leagueService';
import { toastError } from '../../utils/toast';
import LeagueForm from './LeagueForm.vue';
import {
    buildLeaguePayload,
    createEmptyLeagueForm,
    populateLeagueForm,
} from './leagueHelpers';

const route = useRoute();
const router = useRouter();
const id = route.params.id;
const loading = ref(true);
const loadError = ref(false);
const submitting = ref(false);
const form = ref(createEmptyLeagueForm());

const fetchLeague = async () => {
    loading.value = true;
    loadError.value = false;

    try {
        const league = await getLeague(id);

        if (!league.id) {
            throw new Error('League not found.');
        }

        form.value = populateLeagueForm(league);
    } catch (error) {
        loadError.value = true;
        toastError('Failed to load league data.');
    } finally {
        loading.value = false;
    }
};

const handleSubmit = async () => {
    let payload;

    try {
        payload = buildLeaguePayload(form.value);
    } catch (error) {
        toastError('Meta must contain valid JSON.');
        return;
    }

    submitting.value = true;

    try {
        await updateLeague(id, payload);
        await router.push({ name: 'ShowLeague', params: { id } });
    } catch (error) {
        if (!error.__toastShown) {
            toastError('Failed to update league. Please try again.');
        }
    } finally {
        submitting.value = false;
    }
};

onMounted(fetchLeague);
</script>
