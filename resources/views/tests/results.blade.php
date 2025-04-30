@extends('layouts.admin')

@section('content')
<style>
     body {
      background: linear-gradient(135deg, #74ebd5, #acb6e5);
      animation: fadeIn 1s ease-in;
    }

    .card {
        background: rgba(255, 255, 255, 0.75);
        border-radius: 20px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        backdrop-filter: blur(10px);
        animation: fadeIn 0.8s ease-in-out;
    }

    .card-body {
        padding: 2rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .btn-secondary {
        background-color: #fefcea;
        border-color: #fefcea;
    }

    .btn-secondary:hover {
        background-color: #f1da36;
        border-color: #f1da36;
    }

    .btn-info {
        background-color: #ff6a00;
        border-color: #ff6a00;
    }

    .btn-info:hover {
        background-color: #ee0979;
        border-color: #ee0979;
    }

    .badge {
        font-size: 0.85rem;
        padding: 5px 12px;
        border-radius: 12px;
    }
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2 heading-gradient">My Test History</h1>
        <a href="{{ route('tests.index') }}" class="btn btn-secondary btn-glow">
            <i class="fas fa-arrow-left"></i> Back to Tests
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Test</th>
                            <th>Date Taken</th>
                            <th>Score</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $result)
                        <tr>
                            <td>{{ $result->test->title }}</td>
                            <td>{{ $result->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>Not yet evaluvated</td>
                            <td>
                                <span class="badge bg-{{ $result->score >= 70 ? 'success' : 'danger' }}">
                                Not yet evaluvated
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('test.results.show', $result) }}" class="btn btn-sm btn-info btn-glow">
                                    <i class="fas fa-eye"></i> View Details
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No test results found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
