<template>
    <div class="bg-surface rounded-2xl shadow-sm border border-border p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-text">Create League</h1>
            <p class="text-sm text-muted mt-1">Add a new league to the platform.</p>
        </div>

        <LeagueForm
            v-model="form"
            submit-label="Create League"
            :submitting="submitting"
            @submit="handleSubmit"
            @cancel="router.push({ name: 'Leagues' })"
        />
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { createLeague } from '../../services/leagues/leagueService';
import { toastError } from '../../utils/toast';
import LeagueForm from './LeagueForm.vue';
import { buildLeaguePayload, createEmptyLeagueForm } from './leagueHelpers';

const router = useRouter();
const submitting = ref(false);
const form = ref(createEmptyLeagueForm());

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
        await createLeague(payload);
        await router.push({ name: 'Leagues' });
    } catch (error) {
        if (!error.__toastShown) {
            toastError('Failed to create league. Please try again.');
        }
    } finally {
        submitting.value = false;
    }
};
</script>
