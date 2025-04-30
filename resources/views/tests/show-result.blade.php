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
        <h1 class="h2">Test Result Details</h1>
        <div>
            <a href="{{ route('test.results') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Results
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h3 class="h4 mb-3">Test Information</h3>
                    <table class="table">
                        <tr>
                            <th>Test:</th>
                            <td>{{ $result->test->title }}</td>
                        </tr>
                        <tr>
                            <th>Date Taken:</th>
                            <td>{{ $result->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Score:</th>
                            <td>Not yet evaluvated</td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                <span class="badge bg-{{ $result->score >= 70 ? 'success' : 'danger' }}">
                                Not yet evaluvated
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <h3 class="h4 mb-3">Recommendations</h3>
                    <div class="card">
                        <div class="card-body">
                            <p>{{ $result->recommendations }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h3 class="h4 mb-3">Your Answers</h3>
            @foreach($result->answers as $answer)
            <div class="mb-4">
                <h5 class="h6 mb-2">Question {{ $loop->iteration }}</h5>
                <p class="mb-2">{{ $answer->question->question }}</p>
                <div class="d-flex align-items-center">
                    <span class="me-2">Your Answer:</span>
                    <span class="badge bg-{{ $answer->is_correct ? 'success' : 'danger' }}">
                        {{ $answer->selected_option }}
                    </span>
                    @if(!$answer->is_correct)
                    <span class="ms-2 text-muted">
                         {{ $answer->question->correct_option }}
                    </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
