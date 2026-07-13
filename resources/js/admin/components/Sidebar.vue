<template>
    <aside class="w-64 bg-white text-black min-h-screen shadow-lg flex flex-col border-r border-gray-200">
        <div class="h-16 flex items-center px-6 border-b border-gray-200">
            <h1 class="text-2xl font-bold tracking-wider text-black">
                FootballApp
            </h1>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <!-- Dashboard -->
            <router-link
                :to="{ name: 'Dashboard' }"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group"
                :class="[
                    $route.name === 'Dashboard'
                        ? 'bg-black text-white shadow-md'
                        : 'text-gray-700 hover:bg-gray-100 hover:text-black'
                ]"
            >
                <svg
                    class="w-5 h-5 mr-3"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                    />
                </svg>

                <span class="font-medium">Dashboard</span>
            </router-link>

            <!-- Users Dropdown -->
            <div>
                <button
                    type="button"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200"
                    :class="[
                        isUsersActive
                            ? 'bg-black text-white shadow-md'
                            : 'text-gray-700 hover:bg-gray-100 hover:text-black'
                    ]"
                    @click="usersOpen = !usersOpen"
                >
                    <span class="flex items-center">
                        <svg
                            class="w-5 h-5 mr-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8zm6 0a3 3 0 100-6 3 3 0 000 6z"
                            />
                        </svg>

                        <span class="font-medium">Users</span>
                    </span>

                    <svg
                        class="w-4 h-4 transition-transform duration-200"
                        :class="{ 'rotate-180': usersOpen }"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"
                        />
                    </svg>
                </button>

                <div v-show="usersOpen" class="mt-2 ml-4 space-y-1">
                    <router-link
                        to="/admin/users"
                        class="flex items-center px-4 py-2 rounded-lg text-sm transition-all duration-200"
                        :class="[
                            $route.path === '/admin/users'
                                ? 'bg-gray-900 text-white'
                                : 'text-gray-600 hover:bg-gray-100 hover:text-black'
                        ]"
                    >
                        All Users
                    </router-link>

                    <router-link
                        to="/admin/users/create"
                        class="flex items-center px-4 py-2 rounded-lg text-sm transition-all duration-200"
                        :class="[
                            $route.path === '/admin/users/create'
                                ? 'bg-gray-900 text-white'
                                : 'text-gray-600 hover:bg-gray-100 hover:text-black'
                        ]"
                    >
                        Create User
                    </router-link>
                </div>
            </div>

            <!-- Leagues Dropdown -->
            <div>
                <button
                    type="button"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200"
                    :class="[
                        isLeaguesActive
                            ? 'bg-black text-white shadow-md'
                            : 'text-gray-700 hover:bg-gray-100 hover:text-black'
                    ]"
                    @click="leaguesOpen = !leaguesOpen"
                >
                    <span class="flex items-center">
                        <svg
                            class="w-5 h-5 mr-3"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M8 21h8M12 17v4M7 4h10v4a5 5 0 01-10 0V4zM5 4H3v3a3 3 0 003 3M19 4h2v3a3 3 0 01-3 3"
                            />
                        </svg>

                        <span class="font-medium">Leagues</span>
                    </span>

                    <svg
                        class="w-4 h-4 transition-transform duration-200"
                        :class="{ 'rotate-180': leaguesOpen }"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 9l-7 7-7-7"
                        />
                    </svg>
                </button>

                <div v-show="leaguesOpen" class="mt-2 ml-4 space-y-1">
                    <router-link
                        to="/admin/leagues"
                        class="flex items-center px-4 py-2 rounded-lg text-sm transition-all duration-200"
                        :class="[
                            $route.path === '/admin/leagues'
                                ? 'bg-gray-900 text-white'
                                : 'text-gray-600 hover:bg-gray-100 hover:text-black'
                        ]"
                    >
                        All Leagues
                    </router-link>

                    <router-link
                        to="/admin/leagues/create"
                        class="flex items-center px-4 py-2 rounded-lg text-sm transition-all duration-200"
                        :class="[
                            $route.path === '/admin/leagues/create'
                                ? 'bg-gray-900 text-white'
                                : 'text-gray-600 hover:bg-gray-100 hover:text-black'
                        ]"
                    >
                        Create League
                    </router-link>
                </div>
            </div>
        </nav>

        <!-- Visit Site Button -->
        <div class="px-4 py-5 border-t border-gray-200">
            <a
                href="/"
                target="_blank"
                rel="noopener noreferrer"
                class="group flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl bg-black text-white font-semibold shadow-md transition-all duration-300 hover:bg-gray-900 hover:scale-[1.03] hover:shadow-lg active:scale-[0.98]"
            >
                <svg
                    class="w-5 h-5 transition-transform duration-300 group-hover:translate-x-1"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M14 3h7m0 0v7m0-7L10 14m-2-4H5a2 2 0 00-2 2v7a2 2 0 002 2h7a2 2 0 002-2v-3"
                    />
                </svg>

                <span>Visit Site</span>
            </a>
        </div>
    </aside>
</template>

<script setup>
import { computed, ref, watch } from 'vue'
import { useRoute } from 'vue-router'

const $route = useRoute()

const usersOpen = ref(false)
const leaguesOpen = ref(false)

const isUsersActive = computed(() => {
    return $route.path.startsWith('/admin/users')
})

const isLeaguesActive = computed(() => {
    return $route.path.startsWith('/admin/leagues')
})

watch(
    () => $route.path,
    () => {
        if (isUsersActive.value) {
            usersOpen.value = true
        }

        if (isLeaguesActive.value) {
            leaguesOpen.value = true
        }
    },
    { immediate: true }
)
</script>
