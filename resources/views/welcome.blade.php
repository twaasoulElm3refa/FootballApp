<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Scores App</title>

    <style>
        :root {
            --bg-main: #06111f;
            --bg-card: rgba(8, 24, 43, 0.78);
            --green: #5cff1a;
            --green-dark: #19d947;
            --cyan: #18dfff;
            --white: #ffffff;
            --text-muted: #a9b8c8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(92, 255, 26, 0.18), transparent 32%),
                radial-gradient(circle at top right, rgba(24, 223, 255, 0.18), transparent 30%),
                linear-gradient(135deg, #03070d 0%, var(--bg-main) 45%, #02050a 100%);
            color: var(--white);
            overflow: hidden;
        }

        .page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
        }

        .glow {
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(92, 255, 26, 0.18), transparent 65%);
            filter: blur(12px);
            z-index: 0;
        }

        .glow-one {
            top: -120px;
            left: -120px;
        }

        .glow-two {
            right: -140px;
            bottom: -140px;
            background: radial-gradient(circle, rgba(24, 223, 255, 0.18), transparent 65%);
        }

        .hero-card {
            position: relative;
            z-index: 2;
            width: 130%;
            max-width: 620px;
            min-height: 560px;
            padding: 56px 32px;
            border-radius: 36px;
            background: var(--bg-card);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow:
                0 30px 90px rgba(0, 0, 0, 0.45),
                inset 0 1px 0 rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(18px);
            text-align: center;
        }

        .logo-wrap {
            width: 230px;
            height: 230px;
            margin: 0 auto 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background:
                radial-gradient(circle, rgba(255, 255, 255, 0.08), transparent 64%);
            position: relative;
        }

        .logo-wrap::before {
            content: "";
            position: absolute;
            inset: -18px;
            border-radius: 50%;
            border: 2px solid rgba(92, 255, 26, 0.18);
            box-shadow: 0 0 45px rgba(92, 255, 26, 0.18);
        }

        .logo-wrap::after {
            content: "";
            position: absolute;
            inset: -34px;
            border-radius: 50%;
            border-top: 2px solid rgba(24, 223, 255, 0.45);
            border-right: 2px solid transparent;
            border-bottom: 2px solid rgba(92, 255, 26, 0.35);
            border-left: 2px solid transparent;
            animation: rotate 9s linear infinite;
        }

        .logo {
            width: 210px;
            max-width: 100%;
            position: relative;
            z-index: 3;
            filter: drop-shadow(0 18px 35px rgba(0, 0, 0, 0.35));
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            margin-bottom: 22px;
            border-radius: 999px;
            background: rgba(24, 223, 255, 0.08);
            border: 1px solid rgba(24, 223, 255, 0.22);
            color: var(--cyan);
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.4px;
        }

        .badge span {
            width: 8px;
            height: 8px;
            background: var(--green);
            border-radius: 50%;
            box-shadow: 0 0 16px var(--green);
        }

        h1 {
            font-size: clamp(36px, 6vw, 58px);
            line-height: 1.05;
            margin-bottom: 18px;
            font-weight: 900;
            letter-spacing: -1.4px;
        }

        h1 strong {
            color: var(--green);
            text-shadow: 0 0 24px rgba(92, 255, 26, 0.28);
        }

        p {
            max-width: 460px;
            margin: 0 auto 34px;
            color: var(--text-muted);
            font-size: 17px;
            line-height: 1.7;
        }

        .actions {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 178px;
            height: 56px;
            padding: 0 28px;
            border-radius: 999px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 800;
            transition: all 0.25s ease;
        }

        .btn-primary {
            color: #03100c;
            background: linear-gradient(135deg, var(--green), var(--cyan));
            box-shadow: 0 18px 35px rgba(92, 255, 26, 0.22);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 24px 50px rgba(24, 223, 255, 0.25);
        }

        .btn-secondary {
            color: var(--white);
            border: 1px solid rgba(255, 255, 255, 0.14);
            background: rgba(255, 255, 255, 0.04);
        }

        .btn-secondary:hover {
            border-color: rgba(92, 255, 26, 0.5);
            color: var(--green);
            transform: translateY(-3px);
        }

        .bottom-line {
            width: 180px;
            height: 4px;
            margin: 40px auto 0;
            border-radius: 999px;
            background: linear-gradient(90deg, transparent, var(--green), var(--cyan), transparent);
            opacity: 0.8;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 576px) {
            .hero-card {
                min-height: auto;
                padding: 42px 22px;
                border-radius: 28px;
            }

            .logo-wrap {
                width: 190px;
                height: 190px;
            }

            .logo {
                width: 175px;
            }

            p {
                font-size: 15px;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <main class="page">
        <div class="glow glow-one"></div>
        <div class="glow glow-two"></div>

        <section class="hero-card">
            <div class="logo-wrap">
                <img src="{{ asset('images/logo.png') }}" alt="Live Scores Logo" class="logo">
            </div>

            <div class="badge">
                <span></span>
                Live Football Scores
            </div>

            <h1>
                Follow Every <strong>Match</strong><br>
                In Real Time
            </h1>

            <p>
                Get instant football scores, live match updates, team stats, notifications,
                and everything happening on the pitch in one fast sports platform.
            </p>

            <div class="actions">
                <a href="#" class="btn btn-primary">Get Started</a>
                <a href="#" class="btn btn-secondary">Explore Matches</a>
            </div>

            <div class="bottom-line"></div>
        </section>
    </main>
</body>
</html>
