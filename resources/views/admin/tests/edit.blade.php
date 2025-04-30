@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h2">Edit Test</h1>
        <a href="{{ route('admin.tests.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Tests
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
            <form action="{{ route('admin.tests.update', $test) }}" method="POST" id="editTestForm">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $test->title) }}" 
                        class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="4" 
                        class="form-control" required>{{ old('description', $test->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" id="is_active" 
                            class="form-check-input" {{ $test->is_active ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <div id="questionsContainer" class="mt-4">
                    <h2 class="h4 mb-3">Test Questions</h2>
                    @if($test->questions->count() > 0)
                        @foreach($test->questions as $index => $question)
                        <div class="card mb-3 question-card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Question {{ $index + 1 }}:</label>
                                    <input type="text" name="questions[{{ $question->id }}][question]" 
                                        value="{{ $question->question }}" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Options:</label>
                                    <div class="options-container">
                                        @foreach($question->options as $optionIndex => $option)
                                        <div class="input-group mb-2">
                                            <input type="text" name="questions[{{ $question->id }}][options][]" 
                                                value="{{ $option }}" class="form-control" required>
                                            @if($optionIndex > 0)
                                            <button type="button" class="btn btn-outline-danger remove-option">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            @endif
                                        </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="btn btn-outline-primary btn-sm add-option mt-2" 
                                        data-question-id="{{ $question->id }}">
                                        <i class="fas fa-plus"></i> Add Option
                                    </button>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Points:</label>
                                    <input type="number" name="questions[{{ $question->id }}][points]" 
                                        value="{{ $question->points }}" class="form-control" min="1" required>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-danger btn-sm remove-question">
                                        <i class="fas fa-trash"></i> Remove Question
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <button type="button" class="btn btn-success" id="addQuestionBtn">
                        <i class="fas fa-plus"></i> Add New Question
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">
                        <i class="fas fa-save"></i> Update Test
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editTestForm');
    const questionsContainer = document.getElementById('questionsContainer');
    const addQuestionBtn = document.getElementById('addQuestionBtn');
    const submitBtn = document.getElementById('submitBtn');

    // Add new question
    addQuestionBtn.addEventListener('click', function() {
        const questionCards = document.querySelectorAll('.question-card');
        const newQuestionId = 'new_' + Date.now();
        const newQuestionNumber = questionCards.length + 1;

        const questionHtml = `
            <div class="card mb-3 question-card">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Question ${newQuestionNumber}:</label>
                        <input type="text" name="questions[${newQuestionId}][question]" 
                            class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Options:</label>
                        <div class="options-container">
                            <div class="input-group mb-2">
                                <input type="text" name="questions[${newQuestionId}][options][]" 
                                    class="form-control" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm add-option mt-2" 
                            data-question-id="${newQuestionId}">
                            <i class="fas fa-plus"></i> Add Option
                        </button>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Points:</label>
                        <input type="number" name="questions[${newQuestionId}][points]" 
                            value="1" class="form-control" min="1" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-danger btn-sm remove-question">
                            <i class="fas fa-trash"></i> Remove Question
                        </button>
                    </div>
                </div>
            </div>
        `;

        questionsContainer.insertAdjacentHTML('beforeend', questionHtml);
    });

    // Event delegation for dynamic elements
    document.addEventListener('click', function(e) {
        // Add option
        if (e.target.closest('.add-option')) {
            const button = e.target.closest('.add-option');
            const questionId = button.dataset.questionId;
            const optionsContainer = button.previousElementSibling;

            const optionHtml = `
                <div class="input-group mb-2">
                    <input type="text" name="questions[${questionId}][options][]" 
                        class="form-control" required>
                    <button type="button" class="btn btn-outline-danger remove-option">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            optionsContainer.insertAdjacentHTML('beforeend', optionHtml);
        }

        // Remove option
        if (e.target.closest('.remove-option')) {
            const button = e.target.closest('.remove-option');
            const optionGroup = button.closest('.input-group');
            const optionsContainer = optionGroup.closest('.options-container');
            
            if (optionsContainer.querySelectorAll('.input-group').length > 1) {
                optionGroup.remove();
            } else {
                alert('Each question must have at least one option.');
            }
        }

        // Remove question
        if (e.target.closest('.remove-question')) {
            if (confirm('Are you sure you want to remove this question?')) {
                const questionCard = e.target.closest('.question-card');
                questionCard.remove();

                // Renumber remaining questions
                document.querySelectorAll('.question-card').forEach((card, index) => {
                    card.querySelector('.fw-bold').textContent = `Question ${index + 1}:`;
                });
            }
        }
    });

    // Form submission
    form.addEventListener('submit', function(e) {
        const questions = document.querySelectorAll('.question-card');
        if (questions.length === 0) {
            e.preventDefault();
            alert('Please add at least one question to the test.');
            return;
        }

        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
    });
});
</script>
@endpush
@endsection
