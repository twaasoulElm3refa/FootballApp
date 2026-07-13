<template>
    <form class="space-y-6" @submit.prevent="$emit('submit')">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <label class="block">
                <span class="block text-sm font-medium text-text mb-2">API League ID *</span>
                <input
                    v-model="form.api_league_id"
                    type="number"
                    min="1"
                    required
                    class="w-full rounded-xl border border-border bg-surface px-4 py-3 text-text focus:border-primary focus:outline-none"
                >
            </label>

            <label class="block">
                <span class="block text-sm font-medium text-text mb-2">Name *</span>
                <input
                    v-model="form.name"
                    type="text"
                    required
                    class="w-full rounded-xl border border-border bg-surface px-4 py-3 text-text focus:border-primary focus:outline-none"
                >
            </label>

            <label class="block">
                <span class="block text-sm font-medium text-text mb-2">Type</span>
                <input
                    v-model="form.type"
                    type="text"
                    class="w-full rounded-xl border border-border bg-surface px-4 py-3 text-text focus:border-primary focus:outline-none"
                >
            </label>

            <label class="block">
                <span class="block text-sm font-medium text-text mb-2">Country</span>
                <input
                    v-model="form.country"
                    type="text"
                    class="w-full rounded-xl border border-border bg-surface px-4 py-3 text-text focus:border-primary focus:outline-none"
                >
            </label>

            <label class="block">
                <span class="block text-sm font-medium text-text mb-2">Logo URL</span>
                <input
                    v-model="form.logo"
                    type="url"
                    class="w-full rounded-xl border border-border bg-surface px-4 py-3 text-text focus:border-primary focus:outline-none"
                >
            </label>

            <label class="block">
                <span class="block text-sm font-medium text-text mb-2">Flag URL</span>
                <input
                    v-model="form.flag"
                    type="url"
                    class="w-full rounded-xl border border-border bg-surface px-4 py-3 text-text focus:border-primary focus:outline-none"
                >
            </label>

            <label class="block">
                <span class="block text-sm font-medium text-text mb-2">Season</span>
                <input
                    v-model="form.season"
                    type="number"
                    class="w-full rounded-xl border border-border bg-surface px-4 py-3 text-text focus:border-primary focus:outline-none"
                >
            </label>

            <label class="block">
                <span class="block text-sm font-medium text-text mb-2">Sort Order</span>
                <input
                    v-model="form.sort_order"
                    type="number"
                    class="w-full rounded-xl border border-border bg-surface px-4 py-3 text-text focus:border-primary focus:outline-none"
                >
            </label>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <label class="flex items-center gap-3 rounded-xl border border-border p-4 cursor-pointer">
                <input v-model="form.is_active" type="checkbox" class="w-5 h-5 accent-primary">
                <span class="text-sm font-medium text-text">Active</span>
            </label>
            <label class="flex items-center gap-3 rounded-xl border border-border p-4 cursor-pointer">
                <input v-model="form.is_featured" type="checkbox" class="w-5 h-5 accent-primary">
                <span class="text-sm font-medium text-text">Featured</span>
            </label>
            <label class="flex items-center gap-3 rounded-xl border border-border p-4 cursor-pointer">
                <input v-model="form.has_standings" type="checkbox" class="w-5 h-5 accent-primary">
                <span class="text-sm font-medium text-text">Has Standings</span>
            </label>
        </div>

        <!-- <label class="block">
            <span class="block text-sm font-medium text-text mb-2">Meta (JSON)</span>
            <textarea
                v-model="form.meta"
                rows="8"
                placeholder='{"key": "value"}'
                class="w-full rounded-xl border border-border bg-surface px-4 py-3 font-mono text-sm text-text focus:border-primary focus:outline-none"
            />
        </label> -->

        <div class="flex flex-wrap justify-end gap-3 pt-2">
            <button
                type="button"
                class="px-5 py-2.5 rounded-xl border border-border text-text font-medium hover:bg-background transition-colors"
                :disabled="submitting"
                @click="$emit('cancel')"
            >
                Cancel
            </button>
            <button
                type="submit"
                class="px-5 py-2.5 rounded-xl bg-primary text-white font-medium hover:opacity-90 disabled:opacity-50 disabled:cursor-not-allowed transition-opacity"
                :disabled="submitting"
            >
                {{ submitting ? 'Loading...' : submitLabel }}
            </button>
        </div>
    </form>
</template>

<script setup>
defineProps({
    submitting: {
        type: Boolean,
        default: false,
    },
    submitLabel: {
        type: String,
        required: true,
    },
});

defineEmits(['submit', 'cancel']);

const form = defineModel({
    type: Object,
    required: true,
});
</script>
