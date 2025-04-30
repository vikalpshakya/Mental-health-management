@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Book New Appointment</h1>
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Appointments
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="expert_id" class="form-label">Select Expert</label>
                    <select name="expert_id" id="expert_id" class="form-select" required>
                        <option value="">Choose an expert...</option>
                        @foreach($experts as $expert)
                        <option value="{{ $expert->id }}">{{ $expert->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="appointment_date" class="form-label">Appointment Date and Time</label>
                    <input type="datetime-local" name="appointment_date" id="appointment_date" 
                        value="{{ old('appointment_date') }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Additional Notes</label>
                    <textarea name="notes" id="notes" rows="4" class="form-control">{{ old('notes') }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-calendar-plus"></i> Book Appointment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set minimum date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('appointment_date').min = today + 'T00:00';
});
</script>
@endpush
@endsection 