@extends('layouts.admin')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #a8edea, #fed6e3);
        overflow-x: hidden;
    }

    .animated-bg {
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        z-index: -1;
        background: url('https://www.transparenttextures.com/patterns/dark-mosaic.png');
        opacity: 0.05;
        animation: animatePattern 60s linear infinite;
    }

    @keyframes animatePattern {
        0% { background-position: 0 0; }
        100% { background-position: 1000px 1000px; }
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        border-radius: 20px;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(12px);
        padding: 2rem;
        animation: fadeIn 1s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .btn-glow:hover {
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.5);
        transform: scale(1.05);
        transition: 0.3s;
    }

    .table th, .table td {
        vertical-align: middle;
    }

    .heading-glow {
        font-weight: bold;
        background: linear-gradient(to right, #6f42c1, #00bcd4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: pulseText 2s infinite;
    }

    @keyframes pulseText {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
    }

    textarea {
        resize: vertical;
    }
</style>

<div class="animated-bg"></div>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 heading-glow">📋 Appointment Details</h1>
        <div>
            <a href="{{ route('appointments.index') }}" class="btn btn-secondary btn-glow">
                <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            @if($appointment->status === 'pending' && auth()->id() === $appointment->user_id)
                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-glow" onclick="return confirm('Cancel this appointment?')">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                </form>
            @endif
        </div>
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

    <div class="glass-card mb-4">
        <div class="row">
            <div class="col-md-6">
                <h3 class="h4 mb-3">🗓️ Appointment Info</h3>
                <table class="table">
                    <tr>
                        <th>ID:</th>
                        <td>{{ $appointment->id }}</td>
                    </tr>
                    <tr>
                        <th>Expert:</th>
                        <td>{{ $appointment->expert->name }}</td>
                    </tr>
                    <tr>
                        <th>Date & Time:</th>
                        <td>{{ $appointment->appointment_date ? $appointment->appointment_date->format('Y-m-d H:i') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <span class="badge bg-{{ $appointment->status === 'pending' ? 'warning' : ($appointment->status === 'approved' ? 'success' : 'danger') }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Created At:</th>
                        <td>{{ $appointment->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                    <tr>
                        <th>Last Updated:</th>
                        <td>{{ $appointment->updated_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                </table>
            </div>

            <div class="col-md-6">
                <h3 class="h4 mb-3">📝 Notes</h3>
                @if($appointment->notes)
                    <div class="card mb-3 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Your Notes</h5>
                            <p class="card-text">{{ $appointment->notes }}</p>
                        </div>
                    </div>
                @endif

                @if($appointment->expert_notes)
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">Expert's Notes</h5>
                            <p class="card-text">{{ $appointment->expert_notes }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if(auth()->user()->role === 'expert' && auth()->id() === $appointment->expert_id && $appointment->status === 'pending')
        <div class="glass-card">
            <h3 class="h4 mb-3">✅ Update Appointment Status</h3>
            <form action="{{ route('appointments.update-status', $appointment) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select name="status" id="status" class="form-select" required>
                                <option value="approved">Approve</option>
                                <option value="rejected">Reject</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="expert_notes" class="form-label">Expert Notes (Optional)</label>
                            <textarea name="expert_notes" id="expert_notes" class="form-control" rows="3">{{ old('expert_notes', $appointment->expert_notes) }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-glow">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
@endsection
