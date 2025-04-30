@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">{{ $test->title }}</h1>
        <a href="{{ route('tests.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Tests
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h3 class="h4 mb-3">Test Description</h3>
            <p>{{ $test->description }}</p>
            <p class="text-muted">Total Questions: {{ $test->total_questions }}</p>
        </div>
    </div>

    <form action="{{ route('tests.submit', $test) }}" method="POST" id="testForm">
        @csrf
        <div class="card">
            <div class="card-body">
                @foreach($test->questions as $index => $question)
                <div class="mb-4">
                    <h4 class="h5 mb-3">Question {{ $index + 1 }}</h4>
                    <p class="mb-3">{{ $question->question }}</p>
                    <div class="options-list">
                        @foreach($question->options as $option)
                        <div class="form-check mb-2">
                            <input type="radio" name="answers[{{ $question->id }}]" 
                                value="{{ $option }}" class="form-check-input" required>
                            <label class="form-check-label">{{ $option }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-paper-plane"></i> Submit Test
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('testForm');
    const submitBtn = document.getElementById('submitBtn');

    form.addEventListener('submit', function(e) {
        // Get all question IDs
        const questionIds = Array.from(document.querySelectorAll('[name^="answers["]'))
            .map(input => input.name.match(/\[(\d+)\]/)[1])
            .filter((value, index, self) => self.indexOf(value) === index);

        // Check if each question has an answer
        const unansweredQuestions = questionIds.filter(questionId => {
            return !document.querySelector(`input[name="answers[${questionId}]"]:checked`);
        });

        if (unansweredQuestions.length > 0) {
            e.preventDefault();
            alert(`Please answer all questions. You have ${unansweredQuestions.length} unanswered question(s).`);
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';
    });
});
</script>
@endpush
@endsection 