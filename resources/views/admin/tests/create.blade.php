@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h5 class="mb-0">Create New Test</h5>
                    <a href="{{ route('admin.tests.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Back to Tests
                    </a>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">    
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.tests.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Test Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Questions</label>
                            <div id="questions-container">
                                <div class="question-item card mb-3">
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Question 1</label>
                                            <input type="text" class="form-control" name="questions[0][question]" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Options</label>
                                            <div class="options-container">
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" name="questions[0][options][]" placeholder="Option 1" required>
                                                    <button type="button" class="btn btn-outline-danger remove-option">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="input-group mb-2">
                                                    <input type="text" class="form-control" name="questions[0][options][]" placeholder="Option 2" required>
                                                    <button type="button" class="btn btn-outline-danger remove-option">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-outline-primary btn-sm add-option">
                                                <i class="fas fa-plus"></i> Add Option
                                            </button>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Points</label>
                                            <input type="number" class="form-control" name="questions[0][points]" min="1" value="1" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary" id="add-question">
                                <i class="fas fa-plus"></i> Add Question
                            </button>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Test
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const questionsContainer = document.getElementById('questions-container');
        const addQuestionBtn = document.getElementById('add-question');
        let questionCount = 1;

        // Add new question
        addQuestionBtn.addEventListener('click', function() {
            const questionHtml = `
                <div class="question-item card mb-3">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Question ${questionCount + 1}</label>
                            <input type="text" class="form-control" name="questions[${questionCount}][question]" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Options</label>
                            <div class="options-container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="questions[${questionCount}][options][]" placeholder="Option 1" required>
                                    <button type="button" class="btn btn-outline-danger remove-option">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="questions[${questionCount}][options][]" placeholder="Option 2" required>
                                    <button type="button" class="btn btn-outline-danger remove-option">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm add-option">
                                <i class="fas fa-plus"></i> Add Option
                            </button>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Points</label>
                            <input type="number" class="form-control" name="questions[${questionCount}][points]" min="1" value="1" required>
                        </div>
                        <button type="button" class="btn btn-outline-danger btn-sm remove-question">
                            <i class="fas fa-trash"></i> Remove Question
                        </button>
                    </div>
                </div>
            `;
            questionsContainer.insertAdjacentHTML('beforeend', questionHtml);
            questionCount++;
        });

        // Remove question
        questionsContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-question')) {
                e.target.closest('.question-item').remove();
            }
        });

        // Add option
        questionsContainer.addEventListener('click', function(e) {
            if (e.target.closest('.add-option')) {
                const optionsContainer = e.target.closest('.options-container');
                const optionHtml = `
                    <div class="input-group mb-2">
                        <input type="text" class="form-control" name="${optionsContainer.querySelector('input').name}" placeholder="New Option" required>
                        <button type="button" class="btn btn-outline-danger remove-option">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
                optionsContainer.insertAdjacentHTML('beforeend', optionHtml);
            }
        });

        // Remove option
        questionsContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-option')) {
                const optionsContainer = e.target.closest('.options-container');
                if (optionsContainer.querySelectorAll('.input-group').length > 2) {
                    e.target.closest('.input-group').remove();
                }
            }
        });
    });
</script>
@endpush
@endsection
