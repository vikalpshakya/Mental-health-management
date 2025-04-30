@extends('layouts.admin')

@section('content')
<style>
    body {
        background: linear-gradient(to right, #fefcea, #f1da36);
    }

    .glass-wrapper {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.75);
        border-radius: 20px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        animation: fadeIn 0.8s ease-in-out;
        padding: 2rem;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .heading-gradient {
        font-weight: bold;
        background: linear-gradient(to right, #ff6a00, #ee0979);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: glow 2s ease-in-out infinite;
    }

    @keyframes glow {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.85; }
    }

    .btn-glow:hover {
        box-shadow: 0 0 12px rgba(255, 99, 132, 0.6);
        transform: scale(1.03);
        transition: all 0.2s ease-in-out;
    }

    .badge {
        font-size: 0.85rem;
        padding: 5px 12px;
        border-radius: 12px;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="glass-wrapper">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="heading-gradient">📝 Tests Management</h2>
                    <a href="{{ route('admin.tests.create') }}" class="btn btn-primary btn-glow">
                        <i class="fas fa-plus me-1"></i> Create New Test
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Questions</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tests as $test)
                                <tr>
                                    <td>{{ $test->id }}</td>
                                    <td>{{ $test->title }}</td>
                                    <td>{{ Str::limit($test->description, 100) }}</td>
                                    <td>{{ $test->questions_count }}</td>
                                    <td>
                                        <span class="badge bg-{{ $test->is_active ? 'success' : 'danger' }}">
                                            {{ $test->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $test->created_at->format('M d, Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.tests.edit', $test) }}" class="btn btn-sm btn-warning btn-glow">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.tests.destroy', $test) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger btn-glow" onclick="return confirm('Are you sure you want to delete this test?')">
                                                    <i class="fas fa-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if($tests->isEmpty())
                                <tr>
                                    <td colspan="7" class="text-center text-muted">No tests available.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
