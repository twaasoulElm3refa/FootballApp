@php
    $logoPath = asset('images/logo.png');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Football Live Scores</title>

    <style>
        :root {
            --deep-navy: #07111f;
            --navy-soft: #0c1b2d;
            --green: #5cff1a;
            --cyan: #18dfff;
            --white: #ffffff;
            --off-white: #f8fbff;
            --text-dark: #07111f;
            --text-muted: #6b7280;
            --glass: rgba(255, 255, 255, 0.72);
            --border: rgba(7, 17, 31, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            min-height: 100%;
            background: var(--off-white);
        }

        body {
            min-height: 100vh;
            overflow-x: hidden;
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--text-dark);
            background:
                radial-gradient(circle at 50% 28%, rgba(92, 255, 26, 0.18), transparent 30%),
                radial-gradient(circle at 72% 52%, rgba(24, 223, 255, 0.16), transparent 32%),
                linear-gradient(135deg, #ffffff 0%, #f8fbff 48%, #eefaff 100%);
        }

        .app-loader {
            position: fixed;
            inset: 0;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            background:
                radial-gradient(circle at 50% 42%, rgba(92, 255, 26, 0.16), transparent 34%),
                radial-gradient(circle at 64% 58%, rgba(24, 223, 255, 0.15), transparent 31%),
                linear-gradient(135deg, #ffffff 0%, #f8fbff 46%, #effbff 100%);
            transition: opacity 0.55s ease, visibility 0.55s ease, transform 0.55s ease;
        }

        .app-loader.loaded {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: scale(1.015);
        }

        .loader-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 22px;
            text-align: center;
        }

        .logo-orbit {
            position: relative;
            width: 184px;
            height: 184px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .loader-logo {
            position: relative;
            z-index: 3;
            width: 116px;
            height: 116px;
            object-fit: contain;
            filter: drop-shadow(0 18px 34px rgba(7, 17, 31, 0.18));
            animation: logoPulse 1.8s ease-in-out infinite;
        }

        .orbit-ring {
            position: absolute;
            inset: 0;
            border-radius: 999px;
            border: 3px solid transparent;
            border-top-color: var(--green);
            border-right-color: rgba(24, 223, 255, 0.82);
            filter: drop-shadow(0 0 16px rgba(92, 255, 26, 0.36));
            animation: spin 1.1s linear infinite;
        }

        .orbit-ring-two {
            inset: 18px;
            border-top-color: rgba(24, 223, 255, 0.9);
            border-right-color: transparent;
            border-bottom-color: rgba(92, 255, 26, 0.82);
            animation-duration: 1.75s;
            animation-direction: reverse;
        }

        .loader-text {
            color: rgba(7, 17, 31, 0.7);
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.2px;
        }

        .loader-dots {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .loader-dots span {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--green), var(--cyan));
            box-shadow: 0 0 14px rgba(92, 255, 26, 0.45);
            animation: dotBounce 1s ease-in-out infinite;
        }

        .loader-dots span:nth-child(2) {
            animation-delay: 0.15s;
        }

        .loader-dots span:nth-child(3) {
            animation-delay: 0.3s;
        }

        .home-page {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 20px;
            isolation: isolate;
        }

        .home-page::before,
        .home-page::after {
            content: "";
            position: absolute;
            z-index: -1;
            width: min(42vw, 520px);
            aspect-ratio: 1;
            border-radius: 999px;
            filter: blur(16px);
            opacity: 0.72;
        }

        .home-page::before {
            top: -18%;
            left: -12%;
            background: radial-gradient(circle, rgba(92, 255, 26, 0.19), transparent 68%);
        }

        .home-page::after {
            right: -14%;
            bottom: -18%;
            background: radial-gradient(circle, rgba(24, 223, 255, 0.18), transparent 68%);
        }

        .hero {
            width: min(100%, 920px);
            text-align: center;
            padding: clamp(34px, 6vw, 70px) clamp(20px, 5vw, 64px);
            border: 1px solid var(--border);
            border-radius: 42px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.82), rgba(255, 255, 255, 0.58));
            box-shadow:
                0 30px 80px rgba(7, 17, 31, 0.09),
                inset 0 1px 0 rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(18px);
        }

        .hero-logo-shell {
            width: clamp(116px, 18vw, 164px);
            height: clamp(116px, 18vw, 164px);
            margin: 0 auto 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background:
                radial-gradient(circle, rgba(255, 255, 255, 0.96), rgba(255, 255, 255, 0.54) 62%, transparent 64%),
                conic-gradient(from 120deg, rgba(92, 255, 26, 0.5), rgba(24, 223, 255, 0.42), rgba(92, 255, 26, 0.5));
            box-shadow:
                0 20px 42px rgba(7, 17, 31, 0.12),
                0 0 46px rgba(92, 255, 26, 0.16);
        }

        .hero-logo {
            width: 72%;
            height: 72%;
            object-fit: contain;
            filter: drop-shadow(0 14px 22px rgba(7, 17, 31, 0.16));
        }

        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
            padding: 9px 15px;
            border-radius: 999px;
            color: var(--deep-navy);
            font-size: 13px;
            font-weight: 800;
            background: rgba(255, 255, 255, 0.76);
            border: 1px solid rgba(24, 223, 255, 0.2);
        }

        .hero-kicker::before {
            content: "";
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: var(--green);
            box-shadow: 0 0 16px rgba(92, 255, 26, 0.8);
        }

        h1 {
            max-width: 760px;
            margin: 0 auto;
            color: var(--text-dark);
            font-size: clamp(38px, 7vw, 78px);
            line-height: 0.96;
            font-weight: 950;
            letter-spacing: -0.02em;
        }

        .hero-description {
            max-width: 650px;
            margin: 22px auto 0;
            color: var(--text-muted);
            font-size: clamp(16px, 2vw, 19px);
            line-height: 1.75;
        }

        .pills {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin: 30px auto 0;
        }

        .pill {
            padding: 10px 15px;
            border-radius: 999px;
            color: var(--deep-navy);
            font-size: 14px;
            font-weight: 800;
            background: rgba(255, 255, 255, 0.82);
            border: 1px solid rgba(7, 17, 31, 0.08);
            box-shadow: 0 10px 26px rgba(7, 17, 31, 0.05);
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 34px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 166px;
            min-height: 54px;
            padding: 14px 26px;
            border-radius: 999px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 900;
            transition: transform 0.24s ease, box-shadow 0.24s ease, border-color 0.24s ease;
        }

        .btn-primary {
            color: #03110b;
            background: linear-gradient(135deg, var(--green), var(--cyan));
            box-shadow: 0 18px 38px rgba(24, 223, 255, 0.18), 0 14px 30px rgba(92, 255, 26, 0.16);
        }

        .btn-secondary {
            color: var(--text-dark);
            background: rgba(255, 255, 255, 0.62);
            border: 1px solid rgba(7, 17, 31, 0.12);
        }

        .btn:hover {
            transform: translateY(-3px);
        }

        .btn-primary:hover {
            box-shadow: 0 22px 48px rgba(24, 223, 255, 0.24), 0 18px 36px rgba(92, 255, 26, 0.22);
        }

        .btn-secondary:hover {
            border-color: rgba(92, 255, 26, 0.52);
            box-shadow: 0 18px 36px rgba(7, 17, 31, 0.08);
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes logoPulse {
            0%, 100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.055);
            }
        }

        @keyframes dotBounce {
            0%, 100% {
                opacity: 0.48;
                transform: translateY(0);
            }

            50% {
                opacity: 1;
                transform: translateY(-7px);
            }
        }

        @media (max-width: 640px) {
            .logo-orbit {
                width: 146px;
                height: 146px;
            }

            .loader-logo {
                width: 92px;
                height: 92px;
            }

            .hero {
                border-radius: 30px;
            }

            .actions {
                width: 100%;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div id="app-loader" class="app-loader" aria-label="Loading Football Experience">
        <div class="loader-content">
            <div class="logo-orbit">
                <span class="orbit-ring"></span>
                <span class="orbit-ring orbit-ring-two"></span>
                <img src="{{ $logoPath }}" alt="Football Logo" class="loader-logo">
            </div>

            <div class="loader-text">Loading Football Experience...</div>

            <div class="loader-dots" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <main class="home-page">
        <section class="hero">
            <div class="hero-logo-shell">
                <img src="{{ $logoPath }}" alt="Football Logo" class="hero-logo">
            </div>

            <div class="hero-kicker">Live Football Scores</div>

            <h1>Your Football World, Live.</h1>

            <p class="hero-description">
                Follow live scores, matches, teams, standings, and instant football updates in one place.
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

    <script>
        (function () {
            const loader = document.getElementById('app-loader');

            if (!loader) {
                return;
            }

            let hidden = false;

            function hideLoader() {
                if (hidden) {
                    return;
                }

                hidden = true;

                setTimeout(function () {
                    loader.classList.add('loaded');

                    setTimeout(function () {
                        loader.style.display = 'none';
                    }, 650);
                }, 950);
            }

            window.addEventListener('load', hideLoader);
            setTimeout(hideLoader, 1200);
        })();
    </script>
</body>
</html>
