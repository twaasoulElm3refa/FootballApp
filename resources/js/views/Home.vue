<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

const logoUrl = computed(() => window.appConfig?.logoUrl || '/images/logo.png');

const isLoaded = ref(false);
const isLoaderVisible = ref(true);
const loaderStartedAt = performance.now();
const minLoaderDuration = 2500;
const loaderTransitionDuration = 650;

let loadTimer = null;
let fallbackTimer = null;
let removeTimer = null;
let hideScheduled = false;

function hideLoader() {
    if (isLoaded.value || hideScheduled) {
        return;
    }

    hideScheduled = true;

    const elapsed = performance.now() - loaderStartedAt;
    const remainingTime = Math.max(minLoaderDuration - elapsed, 0);

    loadTimer = setTimeout(() => {
        isLoaded.value = true;

        removeTimer = setTimeout(() => {
            isLoaderVisible.value = false;
        }, loaderTransitionDuration);
    }, remainingTime);
}

onMounted(() => {
    if (document.readyState === 'complete') {
        hideLoader();
    } else {
        window.addEventListener('load', hideLoader, { once: true });
    }

    fallbackTimer = setTimeout(hideLoader, minLoaderDuration);
});

onBeforeUnmount(() => {
    window.removeEventListener('load', hideLoader);
    clearTimeout(loadTimer);
    clearTimeout(fallbackTimer);
    clearTimeout(removeTimer);
});
</script>

<template>
    <div
        v-if="isLoaderVisible"
        class="football-loader"
        :class="{ loaded: isLoaded }"
        aria-label="Loading Football Experience"
    >
        <div class="football-loader-content">
            <div class="football-loader-orbit">
                <span class="loader-ring loader-ring-one"></span>
                <span class="loader-ring loader-ring-two"></span>
                <span class="loader-ring loader-ring-three"></span>

                <div class="loader-logo-box">
                    <img :src="logoUrl" alt="Football Logo">
                </div>
            </div>

            <div class="loader-title">Loading Football Experience...</div>

            <div class="loader-progress" aria-hidden="true">
                <span></span>
            </div>
        </div>
    </div>

    <main class="home-page">
        <section class="hero">
            <div class="hero-logo-wrap">
                <span class="hero-rotating-ring"></span>
                <span class="hero-rotating-ring hero-rotating-ring-two"></span>

                <div class="hero-logo-shell">
                    <div class="hero-logo-mask">
                        <img :src="logoUrl" alt="Football Logo" class="hero-logo">
                    </div>
                </div>
            </div>

            <div class="hero-kicker">Live Football Scores</div>

            <h1 class="hero-title">
                Follow Every <span>Match</span><br>
                In Real Time
            </h1>

            <p class="hero-description">
                Get instant football scores, live match updates, team stats,
                notifications, and everything happening on the pitch in one
                fast sports platform.
            </p>

            <div class="pills" aria-label="Football app features">
                <span class="pill">Live Scores</span>
                <span class="pill">Match Alerts</span>
                <span class="pill">Team Stats</span>
            </div>

            <div class="actions">
                <a href="#" class="btn btn-primary">Get Started</a>
                <a href="#" class="btn btn-secondary">Explore Matches</a>
            </div>
        </section>
    </main>
</template>

<style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html,
body,
#app {
    width: 100%;
    height: 100%;
    min-height: 100%;
    overflow: hidden !important;
    background: var(--color-deep-navy);
}

body {
    font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    color: var(--color-text-primary);
}

body::-webkit-scrollbar {
    display: none;
}

.football-loader {
    position: fixed;
    inset: 0;
    z-index: 999999;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    isolation: isolate;
    background: var(--gradient-loader-bg);
    transition: opacity 0.55s ease, visibility 0.55s ease, transform 0.55s ease;
}

.football-loader::before {
    content: "";
    position: absolute;
    width: min(54vw, 520px);
    aspect-ratio: 1;
    border-radius: var(--radius-full);
    background: var(--gradient-loader-orb);
    filter: blur(10px);
    opacity: 0.95;
    transform: translateY(-4px);
    z-index: -1;
}

.football-loader::after {
    content: "";
    position: absolute;
    inset: -20%;
    z-index: -2;
    opacity: 0.22;
    background: var(--gradient-loader-overlay);
    transform: rotate(-8deg);
}

.football-loader.loaded {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transform: scale(1.015);
}

.football-loader-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 24px;
    text-align: center;
    transform: translateY(-4px);
}

.football-loader-orbit {
    position: relative;
    width: 210px;
    height: 210px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.loader-ring {
    position: absolute;
    border-radius: var(--radius-full);
    background: var(--gradient-loader-ring-one);
    filter: var(--filter-loader-ring);
    -webkit-mask: radial-gradient(
        farthest-side,
        transparent calc(100% - 5px),
        var(--color-black) calc(100% - 5px)
    );
    mask: radial-gradient(
        farthest-side,
        transparent calc(100% - 5px),
        var(--color-black) calc(100% - 5px)
    );
    animation: loaderRotate 1.05s linear infinite;
}

.loader-ring-one {
    inset: 0;
}

.loader-ring-two {
    inset: 24px;
    opacity: 0.78;
    background: var(--gradient-loader-ring-two);
    -webkit-mask: radial-gradient(
        farthest-side,
        transparent calc(100% - 4px),
        var(--color-black) calc(100% - 4px)
    );
    mask: radial-gradient(
        farthest-side,
        transparent calc(100% - 4px),
        var(--color-black) calc(100% - 4px)
    );
    animation: loaderRotateReverse 1.35s linear infinite;
}

.loader-ring-three {
    inset: 47px;
    opacity: 0.5;
    background: var(--gradient-loader-ring-three);
    -webkit-mask: radial-gradient(
        farthest-side,
        transparent calc(100% - 3px),
        var(--color-black) calc(100% - 3px)
    );
    mask: radial-gradient(
        farthest-side,
        transparent calc(100% - 3px),
        var(--color-black) calc(100% - 3px)
    );
    animation: loaderRotate 1.8s linear infinite;
}

.loader-logo-box {
    position: relative;
    z-index: 5;
    width: 92px;
    height: 92px;
    border-radius: 26px;
    overflow: hidden;
    background: var(--color-white);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: var(--shadow-loader-logo);
    animation: loaderLogoPulse 1.65s ease-in-out infinite;
}

.loader-logo-box::before {
    content: "";
    position: absolute;
    inset: -1px;
    border-radius: inherit;
    background: var(--gradient-loader-logo-overlay);
    pointer-events: none;
}

.loader-logo-box img {
    position: relative;
    z-index: 1;
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.loader-title {
    color: var(--color-white-72);
    font-size: 14px;
    font-weight: 800;
    letter-spacing: 0.26px;
    text-shadow: var(--glow-cyan-soft);
}

.loader-progress {
    position: relative;
    width: 172px;
    height: 4px;
    overflow: hidden;
    border-radius: var(--radius-full);
    background: var(--color-white-10);
    box-shadow: var(--shadow-loader-progress);
}

.loader-progress span {
    position: absolute;
    inset: 0 auto 0 0;
    width: 62%;
    border-radius: inherit;
    background: var(--gradient-loader-progress);
    box-shadow: var(--shadow-loader-progress-bar);
    animation: loaderProgress 1.15s ease-in-out infinite;
}

.home-page {
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100dvh;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 16px;
    isolation: isolate;
    background: var(--gradient-page-bg);
}

.home-page::before,
.home-page::after {
    content: "";
    position: absolute;
    z-index: -1;
    width: min(42vw, 520px);
    aspect-ratio: 1;
    border-radius: var(--radius-full);
    filter: blur(18px);
    opacity: 0.7;
}

.home-page::before {
    top: -18%;
    left: -12%;
    background: var(--gradient-green-glow-soft);
}

.home-page::after {
    right: -14%;
    bottom: -18%;
    background: var(--gradient-cyan-glow-soft);
}

.hero {
    width: min(100%, 760px);
    max-height: calc(100dvh - 32px);
    overflow: hidden;
    text-align: center;
    padding: clamp(26px, 4vw, 54px) clamp(20px, 4vw, 54px);
    border: 1px solid var(--color-white-09);
    border-radius: var(--radius-2xl);
    background: var(--gradient-card-dark);
    box-shadow: var(--shadow-card-dark);
    backdrop-filter: blur(18px);
}

.hero-logo-wrap {
    position: relative;
    width: clamp(184px, 22vw, 250px);
    height: clamp(184px, 22vw, 250px);
    margin: 0 auto 22px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-rotating-ring {
    position: absolute;
    inset: 0;
    border-radius: var(--radius-full);
    background: var(--gradient-ring);
    -webkit-mask: radial-gradient(
        farthest-side,
        transparent calc(100% - 5px),
        var(--color-black) calc(100% - 5px)
    );
    mask: radial-gradient(
        farthest-side,
        transparent calc(100% - 5px),
        var(--color-black) calc(100% - 5px)
    );
    opacity: 0.9;
    filter: var(--filter-hero-ring);
    animation: heroRingSpin 8s linear infinite;
}

.hero-rotating-ring-two {
    inset: 17px;
    opacity: 0.52;
    background: var(--gradient-ring-secondary);
    -webkit-mask: radial-gradient(
        farthest-side,
        transparent calc(100% - 4px),
        var(--color-black) calc(100% - 4px)
    );
    mask: radial-gradient(
        farthest-side,
        transparent calc(100% - 4px),
        var(--color-black) calc(100% - 4px)
    );
    animation: heroRingSpinReverse 11s linear infinite;
}

.hero-logo-shell {
    position: relative;
    z-index: 3;
    width: clamp(104px, 13vw, 150px);
    height: clamp(104px, 13vw, 150px);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-full);
    background: var(--gradient-hero-logo-shell);
    box-shadow: var(--shadow-hero-logo-shell);
}

.hero-logo-mask {
    width: 72%;
    height: 72%;
    border-radius: var(--radius-xl);
    overflow: hidden;
    background: var(--color-white);
    display: flex;
    align-items: center;
    justify-content: center;
    filter: var(--filter-logo-mask);
}

.hero-logo {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.hero-kicker {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 18px;
    padding: 9px 15px;
    border-radius: var(--radius-full);
    color: var(--color-cyan);
    font-size: 13px;
    font-weight: 800;
    background: var(--color-cyan-08);
    border: 1px solid var(--color-cyan-28);
}

.hero-kicker::before {
    content: "";
    width: 8px;
    height: 8px;
    border-radius: var(--radius-full);
    background: var(--color-green);
    box-shadow: var(--glow-green);
}

.hero-title {
    max-width: 680px;
    margin: 0 auto;
    color: var(--color-text-primary);
    font-size: clamp(36px, 5vw, 64px);
    line-height: 0.96;
    font-weight: 950;
    letter-spacing: -0.02em;
}

.hero-title span {
    color: var(--color-green);
    text-shadow: var(--glow-green-text);
}

.hero-description {
    max-width: 620px;
    margin: 20px auto 0;
    color: var(--color-text-muted);
    font-size: clamp(15px, 1.6vw, 17px);
    line-height: 1.75;
}

.pills {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
    margin: 28px auto 0;
}

.pill {
    padding: 10px 15px;
    border-radius: var(--radius-full);
    color: var(--color-text-primary);
    font-size: 14px;
    font-weight: 800;
    background: var(--color-white-07);
    border: 1px solid var(--color-white-12);
    box-shadow: none;
}

.actions {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 14px;
    margin-top: 32px;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 166px;
    min-height: 54px;
    padding: 14px 26px;
    border-radius: var(--radius-full);
    text-decoration: none;
    font-size: 15px;
    font-weight: 900;
    transition: transform 0.24s ease, box-shadow 0.24s ease, border-color 0.24s ease, background 0.24s ease;
}

.btn-primary {
    color: var(--color-brand-ink);
    background: var(--gradient-brand);
    box-shadow: var(--shadow-brand);
}

.btn-secondary {
    color: var(--color-text-primary);
    background: var(--color-white-06);
    border: 1px solid var(--color-white-18);
}

.btn:hover {
    transform: translateY(-3px);
}

.btn-primary:hover {
    box-shadow: var(--shadow-brand-hover);
}

.btn-secondary:hover {
    border-color: var(--color-green-52);
    background: var(--color-white-09);
    box-shadow: var(--shadow-secondary-hover);
}

@keyframes loaderRotate {
    to {
        transform: rotate(360deg);
    }
}

@keyframes loaderRotateReverse {
    to {
        transform: rotate(-360deg);
    }
}

@keyframes loaderLogoPulse {
    0%, 100% {
        transform: scale(1);
    }

    50% {
        transform: scale(1.055);
    }
}

@keyframes loaderProgress {
    0% {
        transform: translateX(-105%);
        opacity: 0.35;
    }

    45% {
        opacity: 1;
    }

    100% {
        transform: translateX(175%);
        opacity: 0.35;
    }
}

@keyframes heroRingSpin {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}

@keyframes heroRingSpinReverse {
    from {
        transform: rotate(360deg);
    }

    to {
        transform: rotate(0deg);
    }
}

@media (max-height: 760px) {
    .hero {
        padding: 24px 36px;
    }

    .hero-logo-wrap {
        width: 170px;
        height: 170px;
        margin-bottom: 14px;
    }

    .hero-logo-shell {
        width: 104px;
        height: 104px;
    }

    .hero-logo-mask {
        border-radius: 24px;
    }

    .hero-title {
        font-size: clamp(34px, 4.5vw, 54px);
    }

    .hero-description {
        margin-top: 16px;
        line-height: 1.6;
    }

    .pills {
        margin-top: 22px;
    }

    .actions {
        margin-top: 24px;
    }
}

@media (max-width: 640px) {
    .home-page {
        padding: 14px;
    }

    .football-loader-orbit {
        width: 168px;
        height: 168px;
    }

    .loader-logo-box {
        width: 78px;
        height: 78px;
        border-radius: 22px;
    }

    .hero {
        width: 100%;
        border-radius: 28px;
        padding: 28px 20px;
    }

    .hero-logo-wrap {
        width: 176px;
        height: 176px;
        margin-bottom: 18px;
    }

    .hero-logo-shell {
        width: 108px;
        height: 108px;
    }

    .hero-logo-mask {
        border-radius: 26px;
    }

    .hero-title {
        font-size: clamp(34px, 12vw, 48px);
    }

    .actions {
        width: 100%;
    }

    .btn {
        width: 100%;
    }
}
</style>
