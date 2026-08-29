<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('office.app_name', 'Office Task Tracker')) - {{ config('office.company_name', 'Emon Tech Solutions Ltd.') }}</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Chart.js & Confetti Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --primary-light: #e0e7ff;
            --surface: #ffffff;
            --background: #f8fafc;
            --border-color: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --card-bg: #ffffff;
            --card-shadow: 0 4px 20px rgba(0,0,0,0.04);
            --table-hover: #f1f5f9;
        }

        [data-bs-theme="dark"] {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #312e81;
            --surface: #1e293b;
            --background: #0f172a;
            --border-color: #334155;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --card-bg: #1e293b;
            --card-shadow: 0 4px 20px rgba(0,0,0,0.3);
            --table-hover: #293548;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--background);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Navbar Styling */
        .navbar-custom {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 0.85rem 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: #ffffff !important;
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .brand-icon {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.85) !important;
            font-weight: 500;
            padding: 0.5rem 0.9rem !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.14);
        }

        /* Dark Mode Switcher Button */
        .theme-toggle-btn, .device-toggle-btn {
            background: rgba(255, 255, 255, 0.12);
            color: #ffffff;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .device-toggle-btn {
            border-radius: 9999px;
            width: auto;
            padding: 0 0.85rem;
            font-size: 0.82rem;
            font-weight: 600;
        }

        .theme-toggle-btn:hover, .device-toggle-btn:hover {
            background: rgba(255, 255, 255, 0.22);
            transform: translateY(-1px);
        }

        /* Mobile Simulator Container Frame */
        body.mobile-mode-active #mainContainer {
            max-width: 414px !important;
            margin: 1.5rem auto !important;
            border: 10px solid #1e293b;
            border-radius: 36px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.35);
            padding: 1.25rem 0.85rem !important;
            background: var(--bg-body);
            position: relative;
            transition: max-width 0.3s ease, padding 0.3s ease;
        }

        body.mobile-mode-active #mainContainer::before {
            content: '';
            display: block;
            width: 100px;
            height: 18px;
            background: #1e293b;
            border-radius: 0 0 12px 12px;
            margin: -1.25rem auto 1rem auto;
        }

        /* Cards & Surfaces */
        .card-custom {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: var(--card-shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.3s ease;
        }

        .card-custom-interactive:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 28px rgba(0,0,0,0.08);
        }

        /* Stats Cards */
        .stat-card {
            border-radius: 16px;
            padding: 1.35rem;
            color: white;
            position: relative;
            overflow: hidden;
            border: none;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 14px 28px rgba(0,0,0,0.18);
        }

        .stat-card .stat-icon {
            position: absolute;
            right: 1.15rem;
            top: 50%;
            transform: translateY(-50%);
            font-size: 2.75rem;
            opacity: 0.22;
        }

        .stat-card .stat-value {
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1.1;
        }

        .stat-card .stat-label {
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }

        .bg-gradient-total { background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); }
        .bg-gradient-pending { background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%); }
        .bg-gradient-progress { background: linear-gradient(135deg, #0284c7 0%, #38bdf8 100%); }
        .bg-gradient-completed { background: linear-gradient(135deg, #059669 0%, #10b981 100%); }
        .bg-gradient-urgent { background: linear-gradient(135deg, #e11d48 0%, #f43f5e 100%); }

        /* Badges */
        .badge-priority-High { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }
        .badge-priority-Medium { background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; }
        .badge-priority-Low { background-color: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }

        [data-bs-theme="dark"] .badge-priority-High { background-color: #450a0a; color: #fca5a5; border-color: #7f1d1d; }
        [data-bs-theme="dark"] .badge-priority-Medium { background-color: #451a03; color: #fcd34d; border-color: #78350f; }
        [data-bs-theme="dark"] .badge-priority-Low { background-color: #1e293b; color: #cbd5e1; border-color: #334155; }

        .badge-status-Pending { background-color: #ffedd5; color: #c2410c; }
        .badge-status-InProgress { background-color: #e0f2fe; color: #0369a1; }
        .badge-status-Completed { background-color: #dcfce7; color: #15803d; }

        [data-bs-theme="dark"] .badge-status-Pending { background-color: #431407; color: #fdba74; }
        [data-bs-theme="dark"] .badge-status-InProgress { background-color: #082f49; color: #7dd3fc; }
        [data-bs-theme="dark"] .badge-status-Completed { background-color: #052e16; color: #86efac; }

        .badge-overdue {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: #ffffff;
            font-weight: 700;
            animation: pulse-red 2s infinite;
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
        }

        .badge-due-soon {
            background-color: #fef08a;
            color: #854d0e;
            font-weight: 600;
            padding: 0.35rem 0.65rem;
            border-radius: 6px;
        }

        [data-bs-theme="dark"] .badge-due-soon {
            background-color: #713f12;
            color: #fef08a;
        }

        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            70% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        /* Avatar Circle with Colorful Gradients */
        .avatar-circle {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6366f1, #a855f7);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            margin-right: 0.5rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.15);
            flex-shrink: 0;
        }

        /* Quick Status Select */
        .status-select-sm {
            padding: 0.25rem 0.65rem;
            font-size: 0.82rem;
            font-weight: 600;
            border-radius: 8px;
            cursor: pointer;
            border: 1px solid var(--border-color);
            background-color: var(--surface);
            color: var(--text-main);
            transition: all 0.2s ease;
        }

        .status-select-sm:hover {
            border-color: var(--primary);
        }

        /* Kanban Styles */
        .kanban-col {
            background-color: var(--background);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1rem;
            min-height: 480px;
        }

        .kanban-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 0.85rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
            cursor: grab;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .kanban-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0,0,0,0.08);
        }

        /* Footer */
        footer {
            margin-top: auto;
            background-color: #0b0f19;
            color: #94a3b8;
            padding: 1.5rem 0;
            font-size: 0.875rem;
            border-top: 1px solid #1e293b;
        }

        .env-badge {
            background-color: #1e293b;
            color: #38bdf8;
            font-weight: 600;
            padding: 0.25rem 0.65rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .env-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background-color: #22c55e;
            display: inline-block;
        }
    </style>
</head>
<body>

    <!-- Header / Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <div class="brand-icon">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <div>{{ config('office.app_name', 'Office Task Tracker') }}</div>
                    <small style="font-size: 0.72rem; color: #a5b4fc; font-weight: 500; display: block; line-height: 1;">
                        {{ config('office.company_name', 'Emon Tech Solutions Ltd.') }}
                    </small>
                </div>
            </a>

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
                        <a class="btn btn-light fw-bold px-3 py-2 text-primary shadow-sm" href="{{ route('tasks.create') }}" style="border-radius: 10px;">
                            <i class="fa-solid fa-plus me-1 text-primary"></i> Create Task
                        </a>
                    </li>
                    <!-- Device View Switcher (Desktop / Mobile Simulator) -->
                    <li class="nav-item ms-lg-2">
                        <button type="button" id="deviceToggle" class="device-toggle-btn" title="Switch between Desktop & Mobile Simulator">
                            <i class="fa-solid fa-mobile-screen-button me-1" id="deviceIcon"></i>
                            <span id="deviceText">Mobile View</span>
                        </button>
                    </li>
                    <!-- Dark / Light Mode Toggle Button -->
                    <li class="nav-item ms-lg-1">
                        <button type="button" id="themeToggle" class="theme-toggle-btn" title="Toggle Dark/Light Mode">
                            <i class="fa-solid fa-moon" id="themeIcon"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="container my-4 flex-grow-1" id="mainContainer">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="fa-solid fa-circle-check fs-5 me-2"></i>
                <div class="flex-grow-1 fw-medium">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm d-flex align-items-center mb-4" role="alert">
                <i class="fa-solid fa-triangle-exclamation fs-5 me-2"></i>
                <div class="flex-grow-1 fw-medium">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center mb-1">
                    <i class="fa-solid fa-circle-exclamation fs-5 me-2"></i>
                    <strong>Please correct the errors below:</strong>
                </div>
                <ul class="mb-0 ps-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Dynamic Page Content -->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row align-items-center gy-3">
                <div class="col-md-6 text-center text-md-start">
                    <div class="fw-bold text-white mb-1">
                        {{ config('office.company_name', 'Emon Tech Solutions Ltd.') }} &copy; {{ date('Y') }}
                    </div>
                    <small>Support: <a href="mailto:{{ config('office.company_email', 'contact@emontech.com') }}" class="text-decoration-none text-info">{{ config('office.company_email', 'contact@emontech.com') }}</a></small>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    @if(app()->environment('local'))
                        <span class="env-badge">
                            <span class="env-dot"></span>
                            Environment: Development
                        </span>
                    @else
                        <span class="env-badge">
                            <span class="env-dot" style="background-color: #38bdf8;"></span>
                            Environment: Production
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Dark/Light Theme & Confetti Scripts -->
    <script>
        // Confetti Celebration Helper
        function triggerConfetti() {
            if (typeof confetti === 'function') {
                confetti({
                    particleCount: 80,
                    spread: 70,
                    origin: { y: 0.6 },
                    colors: ['#6366f1', '#10b981', '#f59e0b', '#ec4899']
                });
            }
        }

        // Theme Switcher Logic
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const htmlElement = document.documentElement;

        function setTheme(theme) {
            htmlElement.setAttribute('data-bs-theme', theme);
            localStorage.setItem('office_theme', theme);
            if (theme === 'dark') {
                themeIcon.classList.remove('fa-moon');
                themeIcon.classList.add('fa-sun');
            } else {
                themeIcon.classList.remove('fa-sun');
                themeIcon.classList.add('fa-moon');
            }
            // Trigger custom event for charts to redraw if needed
            window.dispatchEvent(new Event('themeChanged'));
        }

        // Check local storage or system preference
        const savedTheme = localStorage.getItem('office_theme') || 
            (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        setTheme(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            setTheme(currentTheme === 'dark' ? 'light' : 'dark');
        });

        // Device View Simulator (Desktop / Mobile Switcher)
        const deviceToggle = document.getElementById('deviceToggle');
        const deviceIcon = document.getElementById('deviceIcon');
        const deviceText = document.getElementById('deviceText');

        deviceToggle.addEventListener('click', () => {
            document.body.classList.toggle('mobile-mode-active');
            const isMobileActive = document.body.classList.contains('mobile-mode-active');

            if (isMobileActive) {
                deviceIcon.className = 'fa-solid fa-desktop me-1';
                deviceText.textContent = 'Desktop View';
                deviceToggle.classList.add('bg-warning', 'text-dark', 'border-warning');
            } else {
                deviceIcon.className = 'fa-solid fa-mobile-screen-button me-1';
                deviceText.textContent = 'Mobile View';
                deviceToggle.classList.remove('bg-warning', 'text-dark', 'border-warning');
            }

            // Force repaint / redraw of charts
            setTimeout(() => {
                window.dispatchEvent(new Event('resize'));
            }, 300);
        });

        // Quick AJAX Status Change
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.quick-status-dropdown').forEach(select => {
                select.addEventListener('change', async function() {
                    const taskId = this.dataset.taskId;
                    const newStatus = this.value;
                    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    try {
                        const response = await fetch(`/tasks/${taskId}/status`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ status: newStatus })
                        });

                        const data = await response.json();
                        if (data.success) {
                            if (newStatus === 'Completed') {
                                triggerConfetti();
                            }
                            // Optional: reload after short delay or update row badge
                            setTimeout(() => window.location.reload(), 400);
                        }
                    } catch (e) {
                        console.error('Status update failed', e);
                    }
                });
            });
        });
    </script>
</body>
</html>
