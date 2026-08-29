<!DOCTYPE html>
<html lang="en" data-bs-theme="dark" data-theme-preset="obsidian">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('office.app_name', 'Office Task Tracker')) - {{ config('office.company_name', 'Emon Tech Solutions Ltd.') }}</title>
    
    <!-- Google Fonts: Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6.5.1 Pro Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js & Confetti Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

    <style>
        /* ==========================================================
           1. LUXURY ENTERPRISE DESIGN SYSTEM & CSS TOKENS
           ========================================================== */
        :root {
            --font-main: 'Plus Jakarta Sans', -apple-system, sans-serif;
            --font-heading: 'Outfit', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
            --radius-sm: 8px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-xl: 28px;
            --transition-smooth: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* 🌌 Preset 1: Obsidian Neon (Default Dark) */
        [data-theme-preset="obsidian"] {
            --primary: #6366f1;
            --primary-rgb: 99, 102, 241;
            --primary-hover: #4f46e5;
            --primary-light: #1e1b4b;
            --accent: #06b6d4;
            --accent-rgb: 6, 182, 212;
            --background: #090d16;
            --surface: #0f172a;
            --surface-hover: #1e293b;
            --card-bg: rgba(15, 23, 42, 0.82);
            --card-border: rgba(255, 255, 255, 0.08);
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border-color: rgba(255, 255, 255, 0.09);
            --card-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(255, 255, 255, 0.06);
            --nav-bg: linear-gradient(135deg, #090d16 0%, #0f172a 45%, #1e1b4b 100%);
            --glow: rgba(99, 102, 241, 0.35);
        }

        /* 💎 Preset 2: Linear Carbon (Minimalist Slate) */
        [data-theme-preset="linear"] {
            --primary: #818cf8;
            --primary-rgb: 129, 140, 248;
            --primary-hover: #6366f1;
            --primary-light: #1e1e2f;
            --accent: #38bdf8;
            --accent-rgb: 56, 189, 248;
            --background: #0d1117;
            --surface: #161b22;
            --surface-hover: #21262d;
            --card-bg: rgba(22, 27, 34, 0.88);
            --card-border: rgba(255, 255, 255, 0.09);
            --text-main: #f0f6fc;
            --text-muted: #8b949e;
            --border-color: #30363d;
            --card-shadow: 0 16px 36px -10px rgba(0, 0, 0, 0.5), 0 0 0 1px #30363d;
            --nav-bg: #161b22;
            --glow: rgba(129, 140, 248, 0.3);
        }

        /* 🌲 Preset 3: Emerald Fintech (Stripe / Wealth Luxe) */
        [data-theme-preset="emerald"] {
            --primary: #10b981;
            --primary-rgb: 16, 185, 129;
            --primary-hover: #059669;
            --primary-light: #064e3b;
            --accent: #14b8a6;
            --accent-rgb: 20, 184, 166;
            --background: #04140f;
            --surface: #062b20;
            --surface-hover: #0b3d2e;
            --card-bg: rgba(6, 38, 28, 0.88);
            --card-border: rgba(16, 185, 129, 0.2);
            --text-main: #ecfdf5;
            --text-muted: #6ee7b7;
            --border-color: rgba(16, 185, 129, 0.18);
            --card-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.7), 0 0 0 1px rgba(16, 185, 129, 0.15);
            --nav-bg: linear-gradient(135deg, #02100c 0%, #06261d 55%, #0b382b 100%);
            --glow: rgba(16, 185, 129, 0.35);
        }

        /* 🌅 Preset 4: Sunset Nebula (Luxe Rose & Violet) */
        [data-theme-preset="sunset"] {
            --primary: #ec4899;
            --primary-rgb: 236, 72, 153;
            --primary-hover: #db2777;
            --primary-light: #500724;
            --accent: #a855f7;
            --accent-rgb: 168, 85, 247;
            --background: #140924;
            --surface: #220f3d;
            --surface-hover: #321659;
            --card-bg: rgba(34, 15, 61, 0.88);
            --card-border: rgba(236, 72, 153, 0.22);
            --text-main: #fdf2f8;
            --text-muted: #f472b6;
            --border-color: rgba(236, 72, 153, 0.18);
            --card-shadow: 0 20px 45px -15px rgba(0, 0, 0, 0.75), 0 0 0 1px rgba(236, 72, 153, 0.2);
            --nav-bg: linear-gradient(135deg, #140924 0%, #290f4a 50%, #4a044e 100%);
            --glow: rgba(236, 72, 153, 0.35);
        }

        /* ☀️ Preset 5: Executive Pearl (Crisp High-Contrast Light) */
        [data-theme-preset="pearl"] {
            --primary: #4f46e5;
            --primary-rgb: 79, 70, 229;
            --primary-hover: #4338ca;
            --primary-light: #e0e7ff;
            --accent: #0284c7;
            --accent-rgb: 2, 132, 199;
            --background: #f8fafc;
            --surface: #ffffff;
            --surface-hover: #f1f5f9;
            --card-bg: #ffffff;
            --card-border: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --card-shadow: 0 12px 32px -8px rgba(0, 0, 0, 0.06), 0 0 0 1px rgba(226, 232, 240, 0.9);
            --nav-bg: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            --glow: rgba(79, 70, 229, 0.25);
        }

        /* Base Body Typography & Styles */
        body {
            font-family: var(--font-main);
            background-color: var(--background);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.3s cubic-bezier(0.4, 0, 0.2, 1), color 0.3s ease;
            letter-spacing: -0.01em;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6, .font-heading {
            font-family: var(--font-heading);
            letter-spacing: -0.03em;
            font-weight: 700;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-color); border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--primary); }

        /* ==========================================================
           2. NAVIGATION & LIVE FLOATING DOCK
           ========================================================== */
        .navbar-custom {
            background: var(--nav-bg);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(20px);
            z-index: 1030;
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.25rem;
            color: #ffffff !important;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .brand-icon {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            width: 42px;
            height: 42px;
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 8px 20px var(--glow);
            transition: var(--transition-smooth);
        }

        .brand-icon:hover {
            transform: rotate(-8deg) scale(1.08);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 600;
            padding: 0.55rem 1rem !important;
            border-radius: 12px;
            transition: var(--transition-smooth);
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.92rem;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            background: rgba(255, 255, 255, 0.12);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.18);
        }

        /* Search Shortcut Button in Navbar */
        .search-shortcut-btn {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: rgba(255, 255, 255, 0.75);
            border-radius: 12px;
            padding: 0.45rem 0.9rem;
            font-size: 0.84rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .search-shortcut-btn:hover {
            background: rgba(255, 255, 255, 0.16);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.3);
        }

        .kbd-key {
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 6px;
            padding: 0.15rem 0.45rem;
            font-size: 0.72rem;
            font-family: var(--font-mono);
            color: #ffffff;
        }

        /* Theme Selector Dropdown */
        .theme-dropdown-menu {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-md);
            box-shadow: var(--card-shadow);
            padding: 0.5rem;
            min-width: 220px;
        }

        .theme-option-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.6rem 0.85rem;
            border-radius: 10px;
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.88rem;
            cursor: pointer;
            transition: var(--transition-smooth);
            text-decoration: none;
        }

        .theme-option-item:hover, .theme-option-item.active {
            background: var(--surface-hover);
            color: var(--primary);
        }

        .theme-color-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 8px rgba(0,0,0,0.3);
        }

        /* Live Active Stopwatch Navbar Badge */
        .live-stopwatch-dock {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.35);
            color: #f87171;
            border-radius: 9999px;
            padding: 0.35rem 0.85rem;
            font-family: var(--font-mono);
            font-weight: 700;
            font-size: 0.82rem;
            display: none;
            align-items: center;
            gap: 0.45rem;
            cursor: pointer;
        }

        .live-stopwatch-dock.active {
            display: inline-flex;
            animation: pulse-timer 1.5s infinite;
        }

        @keyframes pulse-timer {
            0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            50% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
        }

        /* ==========================================================
           3. CARDS, GLASSMORPHISM & ENTERPRISE SURFACES
           ========================================================== */
        .card-custom {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--card-shadow);
            backdrop-filter: blur(18px);
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }

        .card-custom-interactive:hover {
            transform: translateY(-3px);
            border-color: var(--primary);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3), 0 0 0 1px var(--primary);
        }

        /* Radiant Stat Cards */
        .stat-card-enterprise {
            border-radius: var(--radius-lg);
            padding: 1.35rem;
            position: relative;
            overflow: hidden;
            border: 1px solid var(--border-color);
            background: var(--card-bg);
            box-shadow: var(--card-shadow);
            transition: var(--transition-smooth);
        }

        .stat-card-enterprise:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.4), 0 0 0 1px var(--primary);
        }

        .stat-card-enterprise .stat-bg-icon {
            position: absolute;
            right: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 3.2rem;
            opacity: 0.12;
            pointer-events: none;
        }

        /* Priority Radiant Badges */
        .badge-priority-urgent {
            background: linear-gradient(135deg, #ef4444, #b91c1c);
            color: #ffffff;
            font-weight: 800;
            box-shadow: 0 0 12px rgba(239, 68, 68, 0.5);
            animation: urgent-pulse 1.6s infinite;
        }

        @keyframes urgent-pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        .badge-priority-high {
            background: linear-gradient(135deg, #f97316, #ea580c);
            color: #ffffff;
            font-weight: 700;
        }

        .badge-priority-medium {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: #ffffff;
            font-weight: 700;
        }

        .badge-priority-low {
            background: linear-gradient(135deg, #10b981, #059669);
            color: #ffffff;
            font-weight: 700;
        }

        /* Category Badges */
        .badge-cat {
            font-size: 0.72rem;
            font-weight: 700;
            padding: 0.28rem 0.65rem;
            border-radius: 8px;
            letter-spacing: 0.02em;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .badge-cat-dev { background: rgba(99, 102, 241, 0.15); color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3); }
        .badge-cat-ops { background: rgba(6, 182, 212, 0.15); color: #38bdf8; border: 1px solid rgba(6, 182, 212, 0.3); }
        .badge-cat-design { background: rgba(236, 72, 153, 0.15); color: #f472b6; border: 1px solid rgba(236, 72, 153, 0.3); }
        .badge-cat-finance { background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); }
        .badge-cat-marketing { background: rgba(245, 158, 11, 0.15); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.3); }
        .badge-cat-general { background: rgba(100, 116, 139, 0.15); color: #94a3b8; border: 1px solid rgba(100, 116, 139, 0.3); }

        /* Tag Pill Badges */
        .tag-pill {
            font-size: 0.72rem;
            font-weight: 600;
            background: var(--surface-hover);
            color: var(--text-muted);
            border: 1px solid var(--border-color);
            border-radius: 9999px;
            padding: 0.15rem 0.55rem;
            display: inline-flex;
            align-items: center;
            gap: 0.2rem;
        }

        /* Status Pills */
        .status-pill {
            font-size: 0.78rem;
            font-weight: 700;
            padding: 0.35rem 0.8rem;
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
        }

        .badge-status-Pending {
            background-color: rgba(245, 158, 11, 0.12);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.25);
        }

        .badge-status-InProgress {
            background-color: rgba(6, 182, 212, 0.12);
            color: #06b6d4;
            border: 1px solid rgba(6, 182, 212, 0.25);
        }

        .badge-status-Completed {
            background-color: rgba(16, 185, 129, 0.12);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.25);
        }

        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--accent);
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(var(--accent-rgb), 0.7);
            animation: pulse-ring 1.8s infinite cubic-bezier(0.66, 0, 0, 1);
        }

        @keyframes pulse-ring {
            to { box-shadow: 0 0 0 8px rgba(var(--accent-rgb), 0); }
        }

        /* Avatar Circle */
        .avatar-circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 800;
            box-shadow: 0 2px 8px var(--glow);
            flex-shrink: 0;
        }

        /* Pinned Pin Button */
        .pin-btn {
            background: transparent;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            transition: var(--transition-smooth);
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
        }

        .pin-btn:hover, .pin-btn.pinned {
            color: #f59e0b;
            transform: scale(1.15);
        }

        /* Mobile Simulator Container Frame */
        body.mobile-mode-active #mainContainer {
            max-width: 414px !important;
            margin: 1.5rem auto !important;
            border: 14px solid #0f172a;
            border-radius: 46px;
            box-shadow: 0 30px 80px rgba(0, 0, 0, 0.8), 0 0 0 2px rgba(255, 255, 255, 0.1);
            padding: 1.25rem 0.85rem !important;
            background: var(--background);
            position: relative;
            transition: max-width 0.3s ease, padding 0.3s ease;
        }

        body.mobile-mode-active #mainContainer::before {
            content: '';
            display: block;
            width: 120px;
            height: 20px;
            background: #0f172a;
            border-radius: 0 0 16px 16px;
            margin: -1.25rem auto 1.25rem auto;
        }

        /* ==========================================================
           4. COMMAND PALETTE (CTRL + K) SPOTLIGHT MODAL
           ========================================================== */
        .command-palette-backdrop {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(12px);
            z-index: 2000;
            display: none;
            align-items: flex-start;
            justify-content: center;
            padding-top: 10vh;
        }

        .command-palette-backdrop.show {
            display: flex;
            animation: fadeIn 0.15s ease-out;
        }

        .command-palette-box {
            background: var(--surface);
            border: 1px solid var(--card-border);
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 620px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.8), 0 0 0 1px var(--primary);
            overflow: hidden;
            animation: slideDown 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        .command-input-wrapper {
            display: flex;
            align-items: center;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border-color);
            gap: 0.75rem;
        }

        .command-input {
            background: transparent;
            border: none;
            outline: none;
            color: var(--text-main);
            font-size: 1.1rem;
            font-weight: 600;
            width: 100%;
        }

        .command-results-list {
            max-height: 380px;
            overflow-y: auto;
            padding: 0.75rem;
        }

        .command-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 1rem;
            border-radius: var(--radius-md);
            color: var(--text-main);
            text-decoration: none;
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .command-item:hover, .command-item.active {
            background: var(--surface-hover);
            color: var(--primary);
        }

        .command-footer {
            padding: 0.65rem 1.25rem;
            border-top: 1px solid var(--border-color);
            background: rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* Toast Container */
        .toast-container-custom {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 2050;
        }

        /* Footer */
        footer {
            background: var(--surface);
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
            margin-top: auto;
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <div class="brand-icon">
                    <i class="fa-solid fa-bolt-lightning"></i>
                </div>
                <div>
                    <div class="font-heading">{{ config('office.app_name', 'Office Task Tracker') }}</div>
                    <small style="font-size: 0.72rem; color: #a5b4fc; font-weight: 600; display: block; line-height: 1;">
                        {{ config('office.company_name', 'Emon Tech Solutions Ltd.') }}
                    </small>
                </div>
            </a>

            <!-- Search Quick Button (Trigger Ctrl+K) -->
            <button type="button" class="search-shortcut-btn d-none d-md-inline-flex ms-3" onclick="openCommandPalette()">
                <i class="fa-solid fa-magnifying-glass text-muted"></i>
                <span>Quick search & actions...</span>
                <span class="kbd-key">Ctrl + K</span>
            </button>

            <!-- Active Stopwatch Dock in Navbar -->
            <div id="navStopwatchDock" class="live-stopwatch-dock ms-auto me-3" onclick="window.location.href='{{ route('tasks.index') }}'">
                <i class="fa-solid fa-stopwatch fa-spin"></i>
                <span id="navStopwatchTimer">00:00:00</span>
                <span class="badge bg-danger text-white rounded-pill px-2 py-0" style="font-size: 0.65rem;">RECORDING</span>
            </div>

            <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa-solid fa-bars"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-1 mt-2 mt-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fa-solid fa-chart-pie me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}" href="{{ route('tasks.index') }}">
                            <i class="fa-solid fa-list-check me-1"></i> All Tasks
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-primary fw-bold px-3 py-2 shadow-sm" href="{{ route('tasks.create') }}" style="border-radius: 12px; background: linear-gradient(135deg, var(--primary), var(--accent)); border: none;">
                            <i class="fa-solid fa-plus me-1"></i> Create Task
                        </a>
                    </li>

                    <!-- Device View Switcher (Desktop / Mobile Simulator) -->
                    <li class="nav-item ms-lg-2">
                        <button type="button" id="deviceToggle" class="btn btn-sm btn-outline-light px-3 py-2 fw-bold" style="border-radius: 12px;" title="Switch between Desktop & Mobile Simulator">
                            <i class="fa-solid fa-mobile-screen-button me-1" id="deviceIcon"></i>
                            <span id="deviceText">Mobile View</span>
                        </button>
                    </li>

                    <!-- 5-Theme Engine Switcher Dropdown -->
                    <li class="nav-item dropdown ms-lg-2">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle px-3 py-2 fw-bold d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 12px;" id="themeDropdownBtn">
                            <span class="theme-color-dot" id="activeThemeDot" style="background: #6366f1;"></span>
                            <span id="activeThemeName">Obsidian</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end theme-dropdown-menu shadow-lg">
                            <li class="dropdown-header text-uppercase small fw-bold text-muted px-3 py-1">Choose SaaS Theme</li>
                            <li>
                                <a class="theme-option-item" href="javascript:void(0)" onclick="setThemePreset('obsidian')">
                                    <span class="theme-color-dot" style="background: #6366f1;"></span>
                                    <span>Obsidian Neon (Dark)</span>
                                </a>
                            </li>
                            <li>
                                <a class="theme-option-item" href="javascript:void(0)" onclick="setThemePreset('linear')">
                                    <span class="theme-color-dot" style="background: #818cf8;"></span>
                                    <span>Linear Carbon (Slate)</span>
                                </a>
                            </li>
                            <li>
                                <a class="theme-option-item" href="javascript:void(0)" onclick="setThemePreset('emerald')">
                                    <span class="theme-color-dot" style="background: #10b981;"></span>
                                    <span>Emerald Fintech (Luxe)</span>
                                </a>
                            </li>
                            <li>
                                <a class="theme-option-item" href="javascript:void(0)" onclick="setThemePreset('sunset')">
                                    <span class="theme-color-dot" style="background: #ec4899;"></span>
                                    <span>Sunset Nebula (Rose)</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider my-1 border-secondary opacity-25"></li>
                            <li>
                                <a class="theme-option-item" href="javascript:void(0)" onclick="setThemePreset('pearl')">
                                    <span class="theme-color-dot" style="background: #4f46e5; border: 1px solid #ccc;"></span>
                                    <span>Executive Pearl (Light)</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Workspace Container -->
    <main class="container my-4 flex-grow-1" id="mainContainer">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm d-flex align-items-center mb-4 border-0" style="background: rgba(16, 185, 129, 0.15); color: #10b981; border-left: 5px solid #10b981 !important;" role="alert">
                <i class="fa-solid fa-circle-check fs-5 me-2"></i>
                <div class="flex-grow-1 fw-bold">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm d-flex align-items-center mb-4 border-0" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border-left: 5px solid #ef4444 !important;" role="alert">
                <i class="fa-solid fa-triangle-exclamation fs-5 me-2"></i>
                <div class="flex-grow-1 fw-bold">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Ctrl + K Command Palette Modal -->
    <div class="command-palette-backdrop" id="commandPalette" onclick="closeCommandPalette(event)">
        <div class="command-palette-box" onclick="event.stopPropagation()">
            <div class="command-input-wrapper">
                <i class="fa-solid fa-magnifying-glass text-primary fs-5"></i>
                <input type="text" id="commandSearchInput" class="command-input" placeholder="Search tasks, jump to pages, or execute actions..." autocomplete="off">
                <span class="kbd-key">ESC</span>
            </div>
            <div class="command-results-list" id="commandResults">
                <!-- Dynamic Search Results will populate here -->
                <div class="text-muted small px-3 py-2 fw-bold text-uppercase">Navigation & Actions</div>
                <a href="{{ route('tasks.create') }}" class="command-item">
                    <div><i class="fa-solid fa-plus-circle text-primary me-2"></i> <strong>Create New Task</strong></div>
                    <span class="kbd-key">N</span>
                </a>
                <a href="{{ route('tasks.index', ['filter' => 'pinned']) }}" class="command-item">
                    <div><i class="fa-solid fa-thumbtack text-warning me-2"></i> <strong>View Pinned / Critical Tasks</strong></div>
                    <span class="badge bg-warning text-dark rounded-pill">Pinned</span>
                </a>
                <a href="{{ route('tasks.index', ['view' => 'kanban']) }}" class="command-item">
                    <div><i class="fa-solid fa-table-columns text-info me-2"></i> <strong>Open Interactive Kanban Board</strong></div>
                    <span class="badge bg-info text-dark rounded-pill">Kanban</span>
                </a>
                <a href="{{ route('tasks.export') }}" class="command-item">
                    <div><i class="fa-solid fa-file-csv text-success me-2"></i> <strong>Export All Tasks to CSV</strong></div>
                    <span class="badge bg-success text-white rounded-pill">Export</span>
                </a>
            </div>
            <div class="command-footer">
                <div><i class="fa-regular fa-keyboard me-1"></i> Use <span class="kbd-key">↑</span> <span class="kbd-key">↓</span> to navigate, <span class="kbd-key">ENTER</span> to select</div>
                <div class="text-muted">Office Task Tracker Pro</div>
            </div>
        </div>
    </div>

    <!-- Toast Notification Container -->
    <div class="toast-container-custom">
        <div id="liveToast" class="toast align-items-center text-white border-0 rounded-4 shadow-lg" role="alert" aria-live="assertive" aria-atomic="true" style="background: var(--surface); border: 1px solid var(--primary) !important;">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center gap-2">
                    <i class="fa-solid fa-circle-check text-success fs-5" id="toastIcon"></i>
                    <span id="toastMessage" class="fw-bold">Action completed successfully!</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="py-4">
        <div class="container">
            <div class="row align-items-center gy-2 text-center text-md-start">
                <div class="col-md-6">
                    <div class="fw-bold text-white fs-6">
                        <i class="fa-solid fa-shield-halved text-primary me-1"></i> {{ config('office.company_name', 'Emon Tech Solutions Ltd.') }}
                    </div>
                    <small class="text-muted">Enterprise Office Task Management Platform &copy; {{ date('Y') }}. All rights reserved.</small>
                </div>
                <div class="col-md-6 text-md-end d-flex flex-column flex-md-row justify-content-md-end align-items-center gap-3">
                    <span class="text-muted small">
                        <i class="fa-regular fa-envelope me-1"></i> {{ config('office.company_email', 'contact@emontech.com') }}
                    </span>
                    <span class="badge border text-info px-3 py-2 rounded-pill small" style="background: var(--surface); border-color: var(--border-color) !important;">
                        <span class="pulse-dot me-1" style="width: 6px; height: 6px; background-color: #22c55e;"></span>
                        Enterprise v2.5
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // ==========================================================
        // 1. 5-THEME ENGINE WITH LOCALSTORAGE PERSISTENCE
        // ==========================================================
        const themePresets = {
            obsidian: { name: 'Obsidian', color: '#6366f1', bsTheme: 'dark' },
            linear: { name: 'Linear Slate', color: '#818cf8', bsTheme: 'dark' },
            emerald: { name: 'Emerald Luxe', color: '#10b981', bsTheme: 'dark' },
            sunset: { name: 'Sunset Nebula', color: '#ec4899', bsTheme: 'dark' },
            pearl: { name: 'Executive Pearl', color: '#4f46e5', bsTheme: 'light' }
        };

        function setThemePreset(presetKey) {
            const config = themePresets[presetKey] || themePresets.obsidian;
            document.documentElement.setAttribute('data-theme-preset', presetKey);
            document.documentElement.setAttribute('data-bs-theme', config.bsTheme);
            localStorage.setItem('office_theme_preset', presetKey);

            document.getElementById('activeThemeDot').style.background = config.color;
            document.getElementById('activeThemeName').textContent = config.name;

            window.dispatchEvent(new CustomEvent('themeChanged', { detail: { preset: presetKey } }));
        }

        const initialPreset = localStorage.getItem('office_theme_preset') || 'obsidian';
        setThemePreset(initialPreset);

        // ==========================================================
        // 2. CONFETTI & TOAST UTILITIES
        // ==========================================================
        function triggerConfetti() {
            if (typeof confetti === 'function') {
                confetti({
                    particleCount: 110,
                    spread: 85,
                    origin: { y: 0.6 },
                    colors: ['#6366f1', '#06b6d4', '#10b981', '#f59e0b', '#ec4899']
                });
            }
        }

        function showToast(message, isSuccess = true) {
            const toastEl = document.getElementById('liveToast');
            document.getElementById('toastMessage').textContent = message;
            document.getElementById('toastIcon').className = isSuccess ? 'fa-solid fa-circle-check text-success fs-5' : 'fa-solid fa-triangle-exclamation text-danger fs-5';
            const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
            toast.show();
        }

        // ==========================================================
        // 3. CTRL + K COMMAND PALETTE
        // ==========================================================
        const commandPalette = document.getElementById('commandPalette');
        const commandSearchInput = document.getElementById('commandSearchInput');
        const commandResults = document.getElementById('commandResults');

        function openCommandPalette() {
            commandPalette.classList.add('show');
            commandSearchInput.value = '';
            commandSearchInput.focus();
            fetchSearchResults('');
        }

        function closeCommandPalette(e) {
            commandPalette.classList.remove('show');
        }

        document.addEventListener('keydown', (e) => {
            if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
                e.preventDefault();
                commandPalette.classList.contains('show') ? closeCommandPalette() : openCommandPalette();
            } else if (e.key === 'Escape' && commandPalette.classList.contains('show')) {
                closeCommandPalette();
            }
        });

        async function fetchSearchResults(query) {
            try {
                const response = await fetch(`/api/quick-search?q=${encodeURIComponent(query)}`);
                const data = await response.json();
                
                if (data.results && data.results.length > 0) {
                    let html = `<div class="text-muted small px-3 py-2 fw-bold text-uppercase">Tasks (${data.results.length})</div>`;
                    data.results.forEach(task => {
                        html += `
                            <a href="${task.url}" class="command-item">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="${task.priority_icon}"></i>
                                    <div>
                                        <div class="fw-bold">${task.title}</div>
                                        <small class="text-muted">${task.category} • ${task.assigned_to}</small>
                                    </div>
                                </div>
                                <span class="badge ${task.status === 'Completed' ? 'bg-success' : (task.status === 'In Progress' ? 'bg-info' : 'bg-warning text-dark')} rounded-pill">${task.status}</span>
                            </a>
                        `;
                    });
                    commandResults.innerHTML = html;
                } else if (query.trim().length > 0) {
                    commandResults.innerHTML = `<div class="p-4 text-center text-muted"><i class="fa-solid fa-box-open fs-2 mb-2 d-block opacity-50"></i>No matching tasks found for "${query}"</div>`;
                }
            } catch (err) {
                console.error(err);
            }
        }

        let debounceTimer;
        commandSearchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchSearchResults(commandSearchInput.value);
            }, 250);
        });

        // ==========================================================
        // 4. DEVICE VIEW SIMULATOR
        // ==========================================================
        const deviceToggle = document.getElementById('deviceToggle');
        const deviceIcon = document.getElementById('deviceIcon');
        const deviceText = document.getElementById('deviceText');

        if (deviceToggle) {
            deviceToggle.addEventListener('click', () => {
                document.body.classList.toggle('mobile-mode-active');
                const isMobileActive = document.body.classList.contains('mobile-mode-active');

                if (isMobileActive) {
                    deviceIcon.className = 'fa-solid fa-desktop me-1';
                    deviceText.textContent = 'Desktop View';
                    deviceToggle.classList.replace('btn-outline-light', 'btn-warning');
                } else {
                    deviceIcon.className = 'fa-solid fa-mobile-screen-button me-1';
                    deviceText.textContent = 'Mobile View';
                    deviceToggle.classList.replace('btn-warning', 'btn-outline-light');
                }

                setTimeout(() => window.dispatchEvent(new Event('resize')), 300);
            });
        }

        // ==========================================================
        // 5. GLOBAL STOPWATCH TIME TRACKER RUNTIME
        // ==========================================================
        let activeStopwatchTaskId = localStorage.getItem('office_active_timer_task_id') || null;
        let stopwatchSeconds = parseInt(localStorage.getItem('office_stopwatch_seconds') || '0', 10);
        let stopwatchInterval = null;

        function formatStopwatchTime(totalSeconds) {
            const hrs = String(Math.floor(totalSeconds / 3600)).padStart(2, '0');
            const mins = String(Math.floor((totalSeconds % 3600) / 60)).padStart(2, '0');
            const secs = String(totalSeconds % 60).padStart(2, '0');
            return `${hrs}:${mins}:${secs}`;
        }

        function updateNavStopwatch() {
            const dock = document.getElementById('navStopwatchDock');
            const timerText = document.getElementById('navStopwatchTimer');
            if (activeStopwatchTaskId) {
                dock.classList.add('active');
                timerText.textContent = formatStopwatchTime(stopwatchSeconds);
            } else {
                dock.classList.remove('active');
            }
        }

        if (activeStopwatchTaskId) {
            stopwatchInterval = setInterval(() => {
                stopwatchSeconds++;
                localStorage.setItem('office_stopwatch_seconds', stopwatchSeconds);
                updateNavStopwatch();
                window.dispatchEvent(new CustomEvent('stopwatchTick', { detail: { seconds: stopwatchSeconds, taskId: activeStopwatchTaskId } }));
            }, 1000);
            updateNavStopwatch();
        }

        window.startTaskTimer = function(taskId, taskTitle) {
            if (activeStopwatchTaskId && activeStopwatchTaskId !== String(taskId)) {
                if (!confirm('Another task timer is currently active. Switch to this task?')) return;
            }
            activeStopwatchTaskId = String(taskId);
            stopwatchSeconds = 0;
            localStorage.setItem('office_active_timer_task_id', activeStopwatchTaskId);
            localStorage.setItem('office_stopwatch_seconds', '0');

            clearInterval(stopwatchInterval);
            stopwatchInterval = setInterval(() => {
                stopwatchSeconds++;
                localStorage.setItem('office_stopwatch_seconds', stopwatchSeconds);
                updateNavStopwatch();
                window.dispatchEvent(new CustomEvent('stopwatchTick', { detail: { seconds: stopwatchSeconds, taskId: activeStopwatchTaskId } }));
            }, 1000);

            updateNavStopwatch();
            showToast(`Stopwatch started for "${taskTitle}"`);
        };

        window.stopAndLogTaskTimer = async function(taskId) {
            if (!activeStopwatchTaskId || activeStopwatchTaskId !== String(taskId)) return;
            
            const minutesToLog = Math.max(1, Math.round(stopwatchSeconds / 60));
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const res = await fetch(`/tasks/${taskId}/log-time`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ minutes: minutesToLog })
                });
                const data = await res.json();
                if (data.success) {
                    clearInterval(stopwatchInterval);
                    activeStopwatchTaskId = null;
                    stopwatchSeconds = 0;
                    localStorage.removeItem('office_active_timer_task_id');
                    localStorage.removeItem('office_stopwatch_seconds');
                    updateNavStopwatch();
                    showToast(data.message);
                    setTimeout(() => window.location.reload(), 600);
                }
            } catch (err) {
                console.error(err);
                showToast('Failed to log time.', false);
            }
        };

        // ==========================================================
        // 6. QUICK PIN / STATUS AJAX HANDLERS
        // ==========================================================
        window.togglePinTask = async function(taskId, btnEl) {
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            try {
                const res = await fetch(`/tasks/${taskId}/toggle-pin`, {
                    method: 'PATCH',
                    headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json' }
                });
                const data = await res.json();
                if (data.success) {
                    showToast(data.message);
                    setTimeout(() => window.location.reload(), 400);
                }
            } catch (e) {
                console.error(e);
            }
        };
    </script>
</body>
</html>
