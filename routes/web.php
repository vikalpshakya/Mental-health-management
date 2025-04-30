<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Temporary route to update user role
Route::get('/update-role', function () {
    $user = User::where('email', 'vikalp.shakya29@gmail.com')->first();
    if ($user) {
        $user->role = 'admin';
        $user->save();
        return 'Role updated successfully!';
    }
    return 'User not found!';
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard')
    ->withoutMiddleware(['admin']);

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Test Routes
    Route::get('/tests', [TestController::class, 'index'])->name('tests.index');
    Route::get('/tests/{test}', [TestController::class, 'show'])->name('tests.show');
    Route::post('/tests/{test}/submit', [TestController::class, 'submit'])->name('tests.submit');
    Route::get('/test-results', [TestController::class, 'results'])->name('test.results');
    Route::get('/test-results/{result}', [TestController::class, 'showResult'])->name('test.results.show');

    // Appointment Routes
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
});

// Expert Routes
Route::middleware(['auth', 'expert'])->group(function () {
    Route::get('/expert/appointments', [AppointmentController::class, 'expertAppointments'])->name('expert.appointments');
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.update-status');
    
    // Expert Test Routes
    Route::prefix('expert')->name('expert.')->group(function () {
        Route::get('/tests', [TestController::class, 'expertTests'])->name('tests.index');
        Route::get('/tests/create', [TestController::class, 'expertCreateTest'])->name('tests.create');
        Route::post('/tests', [TestController::class, 'expertStoreTest'])->name('tests.store');
        Route::get('/tests/{test}/edit', [TestController::class, 'expertEditTest'])->name('tests.edit');
        Route::put('/tests/{test}', [TestController::class, 'expertUpdateTest'])->name('tests.update');
        Route::delete('/tests/{test}', [TestController::class, 'expertDestroyTest'])->name('tests.destroy');

        // Expert Take Tests
        Route::get('/take-tests', [TestController::class, 'expertTakeTests'])->name('take-tests.index');
        Route::get('/take-tests/{test}', [TestController::class, 'expertShowTest'])->name('take-tests.show');
        Route::post('/take-tests/{test}/submit', [TestController::class, 'expertSubmitTest'])->name('take-tests.submit');
        Route::get('/take-tests/results', [TestController::class, 'expertTestResults'])->name('take-tests.results');
        Route::get('/take-tests/results/{result}', [TestController::class, 'expertShowResult'])->name('take-tests.results.show');
    });
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Test Management
    Route::get('/tests', [AdminController::class, 'tests'])->name('tests.index');
    Route::get('/tests/create', [AdminController::class, 'createTest'])->name('tests.create');
    Route::post('/tests', [AdminController::class, 'storeTest'])->name('tests.store');
    Route::get('/tests/{test}/edit', [AdminController::class, 'editTest'])->name('tests.edit');
    Route::put('/tests/{test}', [AdminController::class, 'updateTest'])->name('tests.update');
    Route::delete('/tests/{test}', [AdminController::class, 'destroyTest'])->name('tests.destroy');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    
    // Expert Management
    Route::get('/experts', [AdminController::class, 'experts'])->name('experts.index');
    Route::get('/experts/create', [AdminController::class, 'createExpert'])->name('experts.create');
    Route::post('/experts', [AdminController::class, 'storeExpert'])->name('experts.store');
    Route::get('/experts/{expert}', [AdminController::class, 'showExpert'])->name('experts.show');
    Route::get('/experts/{expert}/edit', [AdminController::class, 'editExpert'])->name('experts.edit');
    Route::put('/experts/{expert}', [AdminController::class, 'updateExpert'])->name('experts.update');
    Route::delete('/experts/{expert}', [AdminController::class, 'destroyExpert'])->name('experts.destroy');
});
