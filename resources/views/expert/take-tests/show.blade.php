@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $test->title }}</h5>
                    <a href="{{ route('expert.take-tests.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Tests
                    </a>
                </div>

                <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-muted">Description</h6>
                        <p>{{ $test->description }}</p>
                    </div>

                    <form action="{{ route('expert.take-tests.submit', $test) }}" method="POST">
                        @csrf

                        @foreach($test->questions as $index => $question)
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h6 class="card-title">Question {{ $index + 1 }}</h6>
                                    <p class="card-text">{{ $question->question }}</p>
                                    <div class="options">
                                        @foreach($question->options as $option)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input" type="radio" 
                                                    name="answers[{{ $question->id }}]" 
                                                    id="question{{ $question->id }}_option{{ $option->id }}" 
                                                    value="{{ $option->option }}" required>
                                                <label class="form-check-label" for="question{{ $question->id }}_option{{ $option->id }}">
                                                    {{ $option->option }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-check"></i> Submit Test
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 