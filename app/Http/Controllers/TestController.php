<?php

namespace App\Http\Controllers;

use App\Models\MentalHealthTest;
use App\Models\TestResult;
use App\Models\TestAnswer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Test;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $tests = MentalHealthTest::where('is_active', true)->get();
        return view('tests.index', compact('tests'));
    }

    public function show(MentalHealthTest $test)
    {
        if (!$test->is_active) {
            return redirect()->route('tests.index')
                ->with('error', 'This test is currently not available.');
        }

        return view('tests.show', compact('test'));
    }

    public function submit(Request $request, MentalHealthTest $test)
    {
        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string'
        ]);

        // Calculate score
        $totalQuestions = $test->questions->count();
        $correctAnswers = 0;

        foreach ($test->questions as $question) {
            if (isset($request->answers[$question->id]) && 
                $request->answers[$question->id] === $question->correct_option) {
                $correctAnswers++;
            }
        }

        $score = ($correctAnswers / $totalQuestions) * 100;

        // Create test result
        $result = TestResult::create([
            'user_id' => auth()->id(),
            'test_id' => $test->id,
            'score' => $score,
            'recommendations' => $this->generateRecommendations($score)
        ]);

        // Save individual answers
        foreach ($request->answers as $questionId => $selectedOption) {
            $question = $test->questions->find($questionId);
            TestAnswer::create([
                'result_id' => $result->id,
                'question_id' => $questionId,
                'selected_option' => $selectedOption,
                'is_correct' => $selectedOption === $question->correct_option
            ]);
        }

        return redirect()->route('test.results.show', $result)
            ->with('success', 'Test completed successfully!');
    }

    public function results()
    {
        $results = TestResult::where('user_id', auth()->id())
            ->with('test')
            ->latest()
            ->get();

        return view('tests.results', compact('results'));
    }

    public function showResult(TestResult $result)
    {
        if ($result->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $result->load(['test.questions', 'answers.question']);
        return view('tests.show-result', compact('result'));
    }

    private function generateRecommendations($score)
    {
        if ($score >= 70) {
            return "Your mental health appears to be in good condition. Continue maintaining a healthy lifestyle and regular check-ins with mental health professionals.";
        } elseif ($score >= 50) {
            return "You're showing some signs of stress or anxiety. Consider scheduling an appointment with a mental health expert for a more detailed assessment.";
        } else {
            return "Your results suggest you might be experiencing significant stress or anxiety. We strongly recommend scheduling an appointment with a mental health expert as soon as possible.";
        }
    }

    // Expert Test Management Methods
    public function expertTests()
    {
        $tests = Test::where('expert_id', auth()->id())
                    ->withCount('questions')
                    ->latest()
                    ->get();
        
        return view('expert.tests.index', compact('tests'));
    }

    public function expertCreateTest()
    {
        return view('expert.tests.create');
    }

    public function expertStoreTest(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*' => 'required|string',
            'questions.*.points' => 'required|integer|min:1',
        ]);

        $test = Test::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'expert_id' => auth()->id(),
            'is_active' => true,
        ]);

        foreach ($validated['questions'] as $questionData) {
            $question = $test->questions()->create([
                'question' => $questionData['question'],
                'points' => $questionData['points'],
            ]);

            foreach ($questionData['options'] as $option) {
                $question->options()->create([
                    'option' => $option,
                ]);
            }
        }

        return redirect()->route('expert.tests.index')
            ->with('success', 'Test created successfully.');
    }

    public function expertEditTest(Test $test)
    {
        if ($test->expert_id !== auth()->id()) {
            abort(403);
        }

        return view('expert.tests.edit', compact('test'));
    }

    public function expertUpdateTest(Request $request, Test $test)
    {
        if ($test->expert_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*' => 'required|string',
            'questions.*.points' => 'required|integer|min:1',
        ]);

        $test->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        // Delete existing questions and options
        $test->questions()->delete();

        // Create new questions and options
        foreach ($validated['questions'] as $questionData) {
            $question = $test->questions()->create([
                'question' => $questionData['question'],
                'points' => $questionData['points'],
            ]);

            foreach ($questionData['options'] as $option) {
                $question->options()->create([
                    'option' => $option,
                ]);
            }
        }

        return redirect()->route('expert.tests.index')
            ->with('success', 'Test updated successfully.');
    }

    public function expertDestroyTest(Test $test)
    {
        if ($test->expert_id !== auth()->id()) {
            abort(403);
        }

        $test->delete();

        return redirect()->route('expert.tests.index')
            ->with('success', 'Test deleted successfully.');
    }

    // Expert Take Test Methods
    public function expertTakeTests()
    {
        $tests = Test::where('is_active', true)
                    ->where('expert_id', '!=', auth()->id())
                    ->withCount('questions')
                    ->latest()
                    ->get();
        return view('expert.take-tests.index', compact('tests'));
    }

    public function expertShowTest(Test $test)
    {
        if ($test->expert_id === auth()->id()) {
            abort(403, 'You cannot take your own test.');
        }

        if (!$test->is_active) {
            return redirect()->route('expert.take-tests.index')
                ->with('error', 'This test is currently not available.');
        }

        return view('expert.take-tests.show', compact('test'));
    }

    public function expertSubmitTest(Request $request, Test $test)
    {
        if ($test->expert_id === auth()->id()) {
            abort(403, 'You cannot take your own test.');
        }

        $request->validate([
            'answers' => 'required|array',
            'answers.*' => 'required|string'
        ]);

        // Calculate score
        $totalQuestions = $test->questions->count();
        $correctAnswers = 0;

        foreach ($test->questions as $question) {
            if (isset($request->answers[$question->id]) && 
                $request->answers[$question->id] === $question->correct_option) {
                $correctAnswers++;
            }
        }

        $score = ($correctAnswers / $totalQuestions) * 100;

        // Create test result
        $result = TestResult::create([
            'user_id' => auth()->id(),
            'test_id' => $test->id,
            'score' => $score,
            'recommendations' => $this->generateRecommendations($score)
        ]);

        // Save individual answers
        foreach ($request->answers as $questionId => $selectedOption) {
            $question = $test->questions->find($questionId);
            TestAnswer::create([
                'result_id' => $result->id,
                'question_id' => $questionId,
                'selected_option' => $selectedOption,
                'is_correct' => $selectedOption === $question->correct_option
            ]);
        }

        return redirect()->route('expert.take-tests.results.show', $result)
            ->with('success', 'Test completed successfully!');
    }

    public function expertTestResults()
    {
        $results = TestResult::where('user_id', auth()->id())
            ->with('test')
            ->latest()
            ->get();

        return view('expert.take-tests.results', compact('results'));
    }

    public function expertShowResult(TestResult $result)
    {
        if ($result->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $result->load(['test.questions', 'answers.question']);
        return view('expert.take-tests.show-result', compact('result'));
    }
} 