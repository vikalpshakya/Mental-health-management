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
    <!-- Custom CSS -->
    <style>
         body {
      background: linear-gradient(135deg, #74ebd5, #acb6e5);
      animation: fadeIn 1s ease-in;
    }
        .navbar {
            padding: 1rem;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .navbar-brand {
            font-weight: bold;
            color: #333;
        }
        .nav-link {
            color: #666;
            margin-right: 1rem;
        }
        .nav-link:hover {
            color: #333;
        }
        .nav-link.active {
            color: #007bff;
            font-weight: 500;
        }
        .container {
            padding: 2rem 1rem;
        }
        .card {
            margin-bottom: 1rem;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .card-body {
            padding: 1.5rem;
        }
        .btn-outline-danger {
            padding: 0.25rem 0.5rem;
        }
        .options-container {
            margin-bottom: 1rem;
        }
        .input-group {
            margin-bottom: 0.5rem;
        }
        .form-label {
            font-weight: 500;
            color: #495057;
        }
        .question-card {
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }
        .question-card:hover {
            box-shadow: 0 4px 8px rgba(0,0,0,.1);
        }
        .add-option {
            margin-top: 0.5rem;
        }
        .remove-question {
            transition: all 0.2s ease;
        }
        .remove-question:hover {
            transform: scale(1.05);
        }
        .alert {
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                                   href="{{ route('admin.dashboard') }}">Admin Panel</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('appointments.*') ? 'active' : '' }}" 
                               href="{{ route('appointments.index') }}">Appointments</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('tests.*') ? 'active' : '' }}" 
                               href="{{ route('tests.index') }}">Tests</a>
                        </li>
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><span class="dropdown-item-text text-muted">Role: {{ ucfirst(Auth::user()->role) }}</span></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt"></i> Logout
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
        {{ $slot }}
    </main>

    <!-- jQuery (required for some Bootstrap features) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Stack for additional scripts -->
    @stack('scripts')
</body>
</html> 