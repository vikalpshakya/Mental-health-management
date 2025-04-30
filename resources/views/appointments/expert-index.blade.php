@extends('layouts.admin')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #fdfbfb, #ebedee);
        overflow-x: hidden;
    }

    .animated-bg {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: -1;
        background: url('https://www.transparenttextures.com/patterns/cubes.png');
        opacity: 0.04;
        animation: scrollBg 80s linear infinite;
    }

    @keyframes scrollBg {
        from { background-position: 0 0; }
        to { background-position: 1000px 1000px; }
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        border-radius: 20px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        padding: 2rem;
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .btn-glow:hover {
        box-shadow: 0 0 12px rgba(0, 123, 255, 0.5);
        transform: translateY(-1px);
        transition: all 0.2s ease-in-out;
    }

    .heading-glow {
        font-weight: bold;
        background: linear-gradient(to right, #6366f1, #60a5fa);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: pulseGlow 2s infinite;
    }

    @keyframes pulseGlow {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
    }

    .badge {
        padding: 6px 12px;
        font-size: 0.85rem;
        border-radius: 12px;
    }
</style>

<div class="animated-bg"></div>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 heading-glow">📅 My Appointments</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="glass-card">
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->id }}</td>
                            <td>{{ $appointment->user->name }}</td>
                            <td>{{ $appointment->appointment_date->format('Y-m-d H:i') }}</td>
                            <td>
                                <span class="badge bg-{{ $appointment->status === 'pending' ? 'warning' : ($appointment->status === 'approved' ? 'success' : 'danger') }}">
                                    {{ ucfirst($appointment->status) }}
                                </span>
                            </td>
                            <td>{{ Str::limit($appointment->notes, 50) }}</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-info btn-glow">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                    @if($appointment->status === 'pending')
                                        <form action="{{ route('appointments.update-status', $appointment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-sm btn-success btn-glow">
                                                <i class="fas fa-check me-1"></i> Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('appointments.update-status', $appointment) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-danger btn-glow">
                                                <i class="fas fa-times me-1"></i> Reject
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No appointments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
