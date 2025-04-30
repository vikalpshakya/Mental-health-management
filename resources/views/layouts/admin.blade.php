<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --info-color: #36b9cc;
            --warning-color: #f6c23e;
            --danger-color: #e74a3b;
            --light-color: #f8f9fc;
            --dark-color: #5a5c69;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fc;
            color: #5a5c69;
        }

        .navbar {
            padding: 1rem;
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover {
            color: var(--primary-color);
            transform: translateY(-1px);
        }

        .nav-link {
            color: var(--secondary-color);
            padding: 0.75rem 1rem;
            border-radius: 0.35rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 500;
        }

        .nav-link:hover {
            color: var(--primary-color);
            background-color: var(--light-color);
            transform: translateY(-1px);
        }

        .nav-link.active {
            color: var(--primary-color);
            background-color: #eaecf4;
            font-weight: 600;
        }

        .nav-item {
            margin-right: 0.5rem;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            padding: 0.5rem 0;
            border-radius: 0.35rem;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--secondary-color);
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover {
            background-color: var(--light-color);
            color: var(--primary-color);
        }

        .dropdown-item-text {
            padding: 0.75rem 1rem;
            color: var(--secondary-color);
        }

        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: #eaecf4;
        }

        .container {
            padding: 2rem 1rem;
        }

        .card {
            margin-bottom: 1.5rem;
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            border-radius: 0.35rem;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 0.5rem 2rem 0 rgba(58, 59, 69, 0.2);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.25rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .btn {
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.35rem;
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }

        .btn-success {
            background-color: var(--success-color);
            border-color: var(--success-color);
        }

        .btn-success:hover {
            background-color: #17a673;
            border-color: #17a673;
        }

        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }

        .btn-danger:hover {
            background-color: #be2617;
            border-color: #be2617;
        }

        .table {
            margin-bottom: 0;
        }

        .table th {
            font-weight: 600;
            color: var(--dark-color);
            border-top: none;
        }

        .table td {
            vertical-align: middle;
        }

        .badge {
            font-weight: 500;
            padding: 0.5em 0.75em;
            border-radius: 0.35rem;
        }

        .alert {
            border: none;
            border-radius: 0.35rem;
            padding: 1rem 1.25rem;
        }

        .form-control, .form-select {
            border-radius: 0.35rem;
            padding: 0.5rem 1rem;
            border: 1px solid #d1d3e2;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }

        .form-label {
            font-weight: 500;
            color: var(--dark-color);
        }

        .input-group {
            border-radius: 0.35rem;
        }

        .input-group .form-control {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        .input-group .btn {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="{{ route('admin.dashboard') }}"> -->
            <a class="navbar-brand" href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : route('appointments.index') }}">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.tests.*') ? 'active' : '' }}" 
                                   href="{{ route('admin.tests.index') }}">
                                    <i class="fas fa-clipboard-list me-1"></i> Tests
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                                   href="{{ route('admin.users.index') }}">
                                    <i class="fas fa-users me-1"></i> Users
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.experts.*') ? 'active' : '' }}" 
                                   href="{{ route('admin.experts.index') }}">
                                    <i class="fas fa-user-tie me-1"></i> Experts
                                </a>
                            </li>
                        @elseif(auth()->user()->role === 'expert')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('expert.tests.*') ? 'active' : '' }}" 
                                   href="{{ route('expert.tests.index') }}">
                                    <i class="fas fa-clipboard-list me-1"></i> My Tests
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('expert.take-tests.*') ? 'active' : '' }}" 
                                   href="{{ route('expert.take-tests.index') }}">
                                    <i class="fas fa-pencil-alt me-1"></i> Take Tests
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('expert.appointments') ? 'active' : '' }}" 
                                   href="{{ route('expert.appointments') }}">
                                    <i class="fas fa-calendar-alt me-1"></i> My Appointments
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('tests.*') ? 'active' : '' }}" 
                                   href="{{ route('tests.index') }}">
                                    <i class="fas fa-clipboard-list me-1"></i> Tests
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}" 
                                   href="{{ route('appointments.index') }}">
                                    <i class="fas fa-calendar-alt me-1"></i> Appointments
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><span class="dropdown-item-text text-muted">Role: {{ ucfirst(Auth::user()->role) }}</span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <!-- jQuery (required for some Bootstrap features) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Stack for additional scripts -->
    @stack('scripts')
</body>
</html>
