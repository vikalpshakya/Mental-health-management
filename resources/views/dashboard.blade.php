<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ config('app.name', 'Laravel') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/dashboard') }}">
                <i class="fas fa-home"></i> Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @if($user->role === 'admin')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.tests.index') }}">
                            <i class="fas fa-clipboard-list"></i> Tests
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.experts.index') }}">
                            <i class="fas fa-user-tie"></i> Experts
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('appointments.index') }}">
                            <i class="fas fa-calendar"></i> Appointments
                        </a>
                    </li>
                    
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> {{ $user->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><span class="dropdown-item-text text-muted">Role: {{ ucfirst($user->role) }}</span></li>
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
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        Quick Actions
                    </div>
                    <div class="list-group list-group-flush">
                        @if($user->role === 'admin')
                        <a href="{{ route('admin.tests.create') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-plus"></i> Create New Test
                        </a>
                        <a href="{{ route('admin.experts.create') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-user-plus"></i> Add New Expert
                        </a>
                        @endif
                        <a href="{{ route('appointments.create') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-calendar-plus"></i> Book Appointment
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Welcome Back, {{ $user->name }}!</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if($user->role === 'admin')
                            <div class="col-md-4 mb-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Users</h5>
                                        <p class="card-text">Manage system users</p>
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-light">View Users</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Tests</h5>
                                        <p class="card-text">Manage test content</p>
                                        <a href="{{ route('admin.tests.index') }}" class="btn btn-light">View Tests</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body">
                                        <h5 class="card-title">Experts</h5>
                                        <p class="card-text">Manage experts</p>
                                        <a href="{{ route('admin.experts.index') }}" class="btn btn-light">View Experts</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="col-md-4 mb-3">
                                <div class="card bg-warning">
                                    <div class="card-body">
                                        <h5 class="card-title">Appointments</h5>
                                        <p class="card-text">View your appointments</p>
                                        <a href="{{ route('appointments.index') }}" class="btn btn-light">View Appointments</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 