@extends('layouts.admin')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #74ebd5, #acb6e5);
        animation: fadeIn 1s ease-in;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Available Tests</h1>
        <div>
            <a href="{{ route('test.results') }}" class="btn btn-info me-2">
                <i class="fas fa-history"></i> View My Results
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        @forelse($tests as $test)
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h3 class="h4 mb-3">{{ $test->title }}</h3>
                    <p class="text-muted mb-3">{{ Str::limit($test->description, 150) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">
                            {{ $test->total_questions }} Questions
                        </span>
                        <a href="{{ route('tests.show', $test) }}" class="btn btn-primary">
                            <i class="fas fa-play"></i> Take Test
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">
                No tests are currently available. Please check back later.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
