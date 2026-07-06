<template>
    <div>
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-text mb-2">Welcome back, {{ authStore.user?.username || 'Admin' }}!
            </h1>
            <p class="text-muted">Here is what's happening with your platform today.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Card 1 -->
            <div
                class="bg-surface rounded-2xl p-6 shadow-sm border border-border transition-transform hover:-translate-y-1 duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-muted mb-1">Total Users</p>
                        <h3 class="text-2xl font-bold text-text">
                            {{ loadingUsersCount ? '...' : totalUsers }}
                        </h3>
                    </div>
                    <div class="p-3 bg-primary bg-opacity-10 rounded-xl text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-success flex items-center font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        12%
                    </span>
                    <span class="text-muted ml-2">vs last month</span>
                </div>
            </div>

            <!-- Card 2 -->
            <div
                class="bg-surface rounded-2xl p-6 shadow-sm border border-border transition-transform hover:-translate-y-1 duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-muted mb-1">Active Matches</p>
                        <h3 class="text-2xl font-bold text-text">42</h3>
                    </div>
                    <div class="p-3 bg-secondary bg-opacity-10 rounded-xl text-secondary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-success flex items-center font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        8%
                    </span>
                    <span class="text-muted ml-2">vs yesterday</span>
                </div>
            </div>

            <!-- Card 3 -->
            <div
                class="bg-surface rounded-2xl p-6 shadow-sm border border-border transition-transform hover:-translate-y-1 duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-muted mb-1">Notifications Sent</p>
                        <h3 class="text-2xl font-bold text-text">1.2M</h3>
                    </div>
                    <div class="p-3 bg-warning bg-opacity-10 rounded-xl text-warning">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-success flex items-center font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        24%
                    </span>
                    <span class="text-muted ml-2">vs last week</span>
                </div>
            </div>

            <!-- Card 4 -->
            <div
                class="bg-surface rounded-2xl p-6 shadow-sm border border-border transition-transform hover:-translate-y-1 duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-muted mb-1">Reported Issues</p>
                        <h3 class="text-2xl font-bold text-text">18</h3>
                    </div>
                    <div class="p-3 bg-danger bg-opacity-10 rounded-xl text-danger">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-danger flex items-center font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                        5%
                    </span>
                    <span class="text-muted ml-2">vs last month</span>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="bg-surface rounded-2xl shadow-sm border border-border p-6 min-h-[400px]">
            <h3 class="text-lg font-bold text-text mb-4">Recent Activity</h3>
            <div class="flex flex-col space-y-4">
                <!-- Dummy List Items -->
                <div v-for="i in 7" :key="i"
                    class="flex items-start pb-4 border-b border-border last:border-0 last:pb-0">
                    <div
                        class="w-10 h-10 rounded-full bg-background flex items-center justify-center text-primary font-bold mr-4 shrink-0">
                        A
                    </div>
                    <div>
                        <p class="text-sm font-medium text-text">New user registered via Google</p>
                        <p class="text-xs text-muted mt-1">10 minutes ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useAuthStore } from '../../store/auth';
import { getUsersCount } from '../../services/dashboardService';

const authStore = useAuthStore();
const totalUsers = ref(0);
const loadingUsersCount = ref(false);

const fetchUsersCount = async () => {
    loadingUsersCount.value = true;

    try {
        totalUsers.value = await getUsersCount();
    } catch (error) {
        totalUsers.value = 0;
    } finally {
        loadingUsersCount.value = false;
    }
};

onMounted(fetchUsersCount);
</script>
