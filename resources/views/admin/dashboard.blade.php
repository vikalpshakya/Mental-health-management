@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Stats -->
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-4">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Experts</h5>
                    <p class="card-text display-4">{{ $totalExperts }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Tests</h5>
                    <p class="card-text display-4">{{ $totalTests }}</p>
                </div>
            </div>
        </div>

        <!-- Recent Appointments -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Recent Appointments</h5>
                </div>
                <div class="card-body">
                    @forelse($recentAppointments as $appointment)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $appointment->user->name }} with {{ $appointment->expert->name }}</h6>
                                    <p class="text-muted mb-0">{{ $appointment->appointment_date->format('F j, Y g:i A') }}</p>
                                </div>
                                <span class="badge bg-{{ $appointment->status === 'pending' ? 'warning' : ($appointment->status === 'confirmed' ? 'success' : ($appointment->status === 'completed' ? 'info' : 'danger')) }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted">No recent appointments</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.tests.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create New Test
                        </a>
                        <a href="{{ route('admin.experts.create') }}" class="btn btn-success">
                            <i class="fas fa-user-plus"></i> Add New Expert
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 