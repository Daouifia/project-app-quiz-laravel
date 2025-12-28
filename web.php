<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\DashboardController;

// Routes d'authentification
Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes protégées
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes Quiz (pour tous les utilisateurs authentifiés)
    Route::get('/quizzes', [QuizController::class, 'index'])->name('quizzes.index');
    Route::get('/quizzes/create', [QuizController::class, 'create'])->name('quizzes.create')->middleware('can:create,App\Models\Quiz');
    Route::post('/quizzes', [QuizController::class, 'store'])->name('quizzes.store')->middleware('can:create,App\Models\Quiz');
    Route::get('/quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show');
    Route::get('/quizzes/{quiz}/edit', [QuizController::class, 'edit'])->name('quizzes.edit')->middleware('can:update,quiz');
    Route::put('/quizzes/{quiz}', [QuizController::class, 'update'])->name('quizzes.update')->middleware('can:update,quiz');
    Route::delete('/quizzes/{quiz}', [QuizController::class, 'destroy'])->name('quizzes.destroy')->middleware('can:delete,quiz');
    
    // Passage et résultats de quiz
    Route::get('/quizzes/{id}/take', [WebController::class, 'takeQuiz'])->name('quizzes.take');
    Route::post('/quizzes/{id}/submit', [WebController::class, 'submitQuiz'])->name('quizzes.submit');
    Route::get('/quiz-results/{resultId}', [QuizController::class, 'showResult'])->name('quizzes.result');
    Route::get('/student/results', [QuizController::class, 'studentResults'])->name('student.results');
    Route::get('/quizzes/{quizId}/results', [QuizController::class, 'statistics'])->name('quizzes.results');
    
    // Routes Professeur
    Route::prefix('professor')->name('professor.')->group(function () {
        Route::get('/dashboard', [WebController::class, 'professorDashboard'])->name('dashboard');
        Route::get('/users', [WebController::class, 'allUsers'])->name('users');
        Route::get('/quizzes', [WebController::class, 'allQuizzes'])->name('quizzes');
        Route::get('/modules', [WebController::class, 'allModules'])->name('modules');
        Route::get('/modules/{module}', [WebController::class, 'moduleQuizzes'])->name('module.quizzes');
        Route::get('/groupes', [WebController::class, 'allGroupes'])->name('groupes');
        Route::get('/groupes/{groupe}', [WebController::class, 'groupeQuizzes'])->name('groupe.quizzes');
    });

    // Routes Étudiant
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [WebController::class, 'studentDashboard'])->name('dashboard');
        Route::get('/users', [WebController::class, 'allUsers'])->name('users');
        Route::get('/quizzes', [WebController::class, 'allQuizzes'])->name('quizzes');
        Route::get('/modules', [WebController::class, 'allModules'])->name('modules');
        Route::get('/modules/{module}', [WebController::class, 'moduleQuizzes'])->name('module.quizzes');
        Route::get('/groupes', [WebController::class, 'allGroupes'])->name('groupes');
        Route::get('/groupes/{groupe}', [WebController::class, 'groupeQuizzes'])->name('groupe.quizzes');
    });

    // Routes Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [WebController::class, 'adminDashboard'])->name('dashboard');
        Route::get('/users', [WebController::class, 'allUsers'])->name('users');
        Route::get('/quizzes', [WebController::class, 'allQuizzes'])->name('quizzes');
        Route::get('/modules', [WebController::class, 'allModules'])->name('modules');
        Route::get('/modules/{module}', [WebController::class, 'moduleQuizzes'])->name('module.quizzes');
        Route::get('/groupes', [WebController::class, 'allGroupes'])->name('groupes');
        Route::get('/groupes/{groupe}', [WebController::class, 'groupeQuizzes'])->name('groupe.quizzes');
    });
});