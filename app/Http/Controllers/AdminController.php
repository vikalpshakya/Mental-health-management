<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MentalHealthTest;
use App\Models\TestQuestion;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalExperts = User::where('role', 'expert')->count();
        $totalTests = MentalHealthTest::count();
        $recentAppointments = Appointment::with(['user', 'expert'])->latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalExperts', 'totalTests', 'recentAppointments'));
    }

    public function tests()
    {
        $tests = MentalHealthTest::withCount('questions')->get();
        return view('admin.tests.index', compact('tests'));
    }

    public function createTest()
    {
        return view('admin.tests.create');
    }

    public function storeTest(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array',
            'questions.*.points' => 'required|integer|min:1'
        ]);

        $test = MentalHealthTest::create([
            'title' => $request->title,
            'description' => $request->description,
            'total_questions' => count($request->questions),
            'is_active' => true
        ]);

        foreach ($request->questions as $question) {
            TestQuestion::create([
                'test_id' => $test->id,
                'question' => $question['question'],
                'options' => $question['options'],
                'points' => $question['points']
            ]);
        }

        return redirect()->route('admin.tests.index')
            ->with('success', 'Test created successfully.');
    }

    public function editTest(MentalHealthTest $test)
    {
        $test->load('questions');
        return view('admin.tests.edit', compact('test'));
    }

    public function updateTest(Request $request, MentalHealthTest $test)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'is_active' => 'nullable|boolean',
            'questions' => 'required|array',
            'questions.*.question' => 'required|string',
            'questions.*.options' => 'required|array',
            'questions.*.points' => 'required|integer|min:1'
        ]);

        $data = $request->only(['title', 'description']);
        $data['is_active'] = $request->has('is_active');
        $data['total_questions'] = count($request->questions);

        $test->update($data);

        // Update existing questions and create new ones
        foreach ($request->questions as $questionId => $questionData) {
            if (str_starts_with($questionId, 'new_')) {
                // Create new question
                TestQuestion::create([
                    'test_id' => $test->id,
                    'question' => $questionData['question'],
                    'options' => $questionData['options'],
                    'points' => $questionData['points']
                ]);
            } else {
                // Update existing question
                $existingQuestion = TestQuestion::find($questionId);
                if ($existingQuestion) {
                    $existingQuestion->update([
                        'question' => $questionData['question'],
                        'options' => $questionData['options'],
                        'points' => $questionData['points']
                    ]);
                }
            }
        }

        // Delete questions that were removed
        $existingQuestionIds = array_keys($request->questions);
        $existingQuestionIds = array_filter($existingQuestionIds, function($id) {
            return !str_starts_with($id, 'new_');
        });
        TestQuestion::where('test_id', $test->id)
            ->whereNotIn('id', $existingQuestionIds)
            ->delete();

        return redirect()->route('admin.tests.index')
            ->with('success', 'Test updated successfully.');
    }

    public function users()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.users.index', compact('users'));
    }

    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,expert,admin',
        ]);

        $user->update($request->only(['name', 'email', 'role']));

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    public function experts()
    {
        $experts = User::where('role', 'expert')->get();
        return view('admin.experts.index', compact('experts'));
    }

    public function createExpert()
    {
        return view('admin.experts.create');
    }

    public function storeExpert(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'expert'
        ]);

        return redirect()->route('admin.experts.index')
            ->with('success', 'Expert created successfully.');
    }

    public function showExpert(User $expert)
    {
        if ($expert->role !== 'expert') {
            return redirect()->route('admin.experts.index')
                ->with('error', 'The selected user is not an expert.');
        }
        return view('admin.experts.show', compact('expert'));
    }

    public function editExpert(User $expert)
    {
        if ($expert->role !== 'expert') {
            return redirect()->route('admin.experts.index')
                ->with('error', 'The selected user is not an expert.');
        }
        return view('admin.experts.edit', compact('expert'));
    }

    public function updateExpert(Request $request, User $expert)
    {
        if ($expert->role !== 'expert') {
            return redirect()->route('admin.experts.index')
                ->with('error', 'The selected user is not an expert.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $expert->id,
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $data = $request->only(['name', 'email']);
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $expert->update($data);

        return redirect()->route('admin.experts.index')
            ->with('success', 'Expert updated successfully.');
    }

    public function destroyExpert(User $expert)
    {
        if ($expert->role !== 'expert') {
            return redirect()->route('admin.experts.index')
                ->with('error', 'The selected user is not an expert.');
        }

        $expert->delete();
        return redirect()->route('admin.experts.index')
            ->with('success', 'Expert deleted successfully.');
    }
} 