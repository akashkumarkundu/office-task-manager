<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', config('office.app_name', 'Office Task Tracker')) - {{ config('office.company_name', 'Zenith Core Ltd.') }}</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FontAwesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--background);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Styling */
        .navbar-custom {
            background: linear-gradient(135deg, #1e1b4b 0%, #312e81 100%);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 0.85rem 1rem;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.25rem;
            color: #ffffff !important;
            display: flex;
            align-items: center;
            gap: 0.6rem;
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
            box-shadow: 0 4px 10px rgba(99, 102, 241, 0.35);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            padding: 0.5rem 0.9rem !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.12);
        }

        /* Cards & Surfaces */
        .card-custom {
            background: var(--surface);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 6px 16px rgba(0,0,0,0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-custom-interactive:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }

        /* Stats Cards */
        .stat-card {
            border-radius: 16px;
            padding: 1.35rem;
            color: white;
            position: relative;
            overflow: hidden;
            border: none;
        }

        .stat-card .stat-icon {
            position: absolute;
            right: 1.25rem;
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

        .badge-status-Pending { background-color: #ffedd5; color: #c2410c; }
        .badge-status-InProgress { background-color: #e0f2fe; color: #0369a1; }
        .badge-status-Completed { background-color: #dcfce7; color: #15803d; }

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

        @keyframes pulse-red {
            0% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
            70% { box-shadow: 0 0 0 8px rgba(239, 68, 68, 0); }
            100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0); }
        }

        /* Avatar Circle */
        .avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: 700;
            margin-right: 0.5rem;
        }

        /* Footer */
        footer {
            margin-top: auto;
            background-color: #0f172a;
            color: #94a3b8;
            padding: 1.5rem 0;
            font-size: 0.875rem;
            border-top: 1px solid #1e293b;
        }

        .env-badge {
            background-color: #334155;
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
                        {{ config('office.company_name', 'Zenith Core Ltd.') }}
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="py-4 flex-grow-1">
        <div class="container">
            <!-- Flash Message: Success -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
                    <div class="me-3 fs-4 text-success">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    <div class="flex-grow-1">
                        <strong>Success!</strong> {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Flash Message: Error -->
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center" role="alert">
                    <div class="me-3 fs-4 text-danger">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="flex-grow-1">
                        <strong>Error!</strong> {{ session('error') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Validation Errors Summary (if any) -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fa-solid fa-circle-exclamation me-2 fs-5"></i>
                        <strong class="fs-6">Please correct the following errors:</strong>
                    </div>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row align-items-center gy-3">
                <div class="col-md-6 text-center text-md-start">
                    <div class="fw-bold text-white mb-1">
                        {{ config('office.company_name', 'Zenith Core Ltd.') }} &copy; {{ date('Y') }}
                    </div>
                    <div class="text-muted small">
                        Support Contact: <a href="mailto:{{ config('office.company_email', 'support@zenithcore.com') }}" class="text-info text-decoration-none">{{ config('office.company_email', 'support@zenithcore.com') }}</a>
                    </div>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    @if(app()->environment('local'))
                        <span class="env-badge">
                            <span class="env-dot"></span>
                            Environment: <strong>Development (Local)</strong>
                        </span>
                    @else
                        <span class="env-badge">
                            <span class="env-dot" style="background-color: #38bdf8;"></span>
                            Environment: <strong>{{ ucfirst(app()->environment()) }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
