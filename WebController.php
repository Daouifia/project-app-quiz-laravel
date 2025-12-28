<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebController extends Controller
{
    // Page d'accueil
    public function index()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === 'professor') {
                return redirect()->route('professor.dashboard');
            } elseif ($user->role === 'student') {
                return redirect()->route('student.dashboard');
            } elseif ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }
        return view('welcome');
    }

    // Traiter l'inscription
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:student,professor,admin',
            'module' => 'nullable|string',
            'groupe' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'module' => $request->module,
            'groupe' => $request->groupe,
        ]);

        return redirect()->route('home')->with('success', 'Inscription réussie ! Vous pouvez maintenant vous connecter.');
    }

    // Traiter la connexion
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'professor') {
                return redirect()->route('professor.dashboard');
            } elseif ($user->role === 'student') {
                return redirect()->route('student.dashboard');
            } elseif ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect.',
        ]);
    }

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    // Dashboard Professeur
    public function professorDashboard()
    {
        $statistics = [
            'total_users' => User::count(),
            'total_quizzes' => Quiz::count(),
            'total_modules' => Quiz::distinct('module')->count('module'),
            'total_groupes' => Quiz::distinct('groupe')->count('groupe'),
        ];

        return view('professor.dashboard', compact('statistics'));
    }

    // Dashboard Étudiant
    public function studentDashboard()
    {
        $statistics = [
            'total_users' => User::count(),
            'total_quizzes' => Quiz::count(),
            'total_modules' => Quiz::distinct('module')->count('module'),
            'total_groupes' => Quiz::distinct('groupe')->count('groupe'),
        ];

        return view('student.dashboard', compact('statistics'));
    }

    // Dashboard Admin
    public function adminDashboard()
    {
        $statistics = [
            'total_users' => User::count(),
            'total_quizzes' => Quiz::count(),
            'total_modules' => Quiz::distinct('module')->count('module'),
            'total_groupes' => Quiz::distinct('groupe')->count('groupe'),
        ];

        return view('admin.dashboard', compact('statistics'));
    }

    // Page Tous les utilisateurs
    public function allUsers()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        $breakdown = [
            'students' => User::where('role', 'student')->count(),
            'professors' => User::where('role', 'professor')->count(),
            'admins' => User::where('role', 'admin')->count(),
        ];

        return view('dashboard.users', compact('users', 'breakdown'));
    }

    // Page Tous les quiz
    public function allQuizzes()
    {
        $quizzes = Quiz::with('professor')->withCount('questions', 'results')->get();
        return view('dashboard.quizzes', compact('quizzes'));
    }

    // Page Tous les modules
    public function allModules()
    {
        $modules = Quiz::select('module')
            ->selectRaw('COUNT(*) as quiz_count')
            ->selectRaw('COUNT(DISTINCT groupe) as groupe_count')
            ->groupBy('module')
            ->get();

        return view('dashboard.modules', compact('modules'));
    }

    // Page Quiz par module
    public function moduleQuizzes($module)
    {
        $quizzes = Quiz::where('module', $module)
            ->withCount('questions', 'results')
            ->get();

        return view('dashboard.module-quizzes', compact('module', 'quizzes'));
    }

    // Page Tous les groupes
    public function allGroupes()
    {
        $groupes = Quiz::select('groupe')
            ->selectRaw('COUNT(*) as quiz_count')
            ->selectRaw('GROUP_CONCAT(DISTINCT module) as modules')
            ->groupBy('groupe')
            ->get();

        return view('dashboard.groupes', compact('groupes'));
    }

    // Page Quiz par groupe
    public function groupeQuizzes($groupe)
    {
        $quizzes = Quiz::where('groupe', $groupe)
            ->withCount('questions', 'results')
            ->get();

        return view('dashboard.groupe-quizzes', compact('groupe', 'quizzes'));
    }

    // Page Créer un quiz (Professeur)
    public function createQuiz()
    {
        return view('professor.create-quiz');
    }

    // Stocker un quiz (Professeur)
    public function storeQuiz(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration' => 'required|integer|min:1',
            'module' => 'required|string',
            'groupe' => 'required|string',
            'questions' => 'required|array|min:1',
            'questions.*.question_text' => 'required|string',
            'questions.*.choices' => 'required|array|min:3|max:4',
            'questions.*.correct_answer' => 'required|integer|min:0|max:3',
        ]);

        $quiz = Quiz::create([
            'professor_id' => Auth::id(),
            'title' => $request->title,
            'duration' => $request->duration,
            'module' => $request->module,
            'groupe' => $request->groupe,
        ]);

        foreach ($request->questions as $questionData) {
            \App\Models\Question::create([
                'quiz_id' => $quiz->id,
                'question_text' => $questionData['question_text'],
                'choices' => $questionData['choices'],
                'correct_answer' => $questionData['correct_answer'],
            ]);
        }

        return redirect()->route('professor.quizzes')->with('success', 'Quiz créé avec succès !');
    }

    // Page Passer un quiz (Étudiant)
    public function takeQuiz($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $student = Auth::user();

        // Vérifier si l'étudiant peut passer ce quiz
        if ($student->role !== 'student' || $student->module !== $quiz->module || $student->groupe !== $quiz->groupe) {
            abort(403, 'Non autorisé à passer ce quiz.');
        }

        // Vérifier si l'étudiant a déjà passé ce quiz
        $hasTaken = \App\Models\QuizResult::where('quiz_id', $quiz->id)->where('student_id', $student->id)->exists();
        if ($hasTaken) {
            return redirect()->route('student.quizzes')->with('error', 'Vous avez déjà passé ce quiz.');
        }

        $questions = $quiz->questions;
        return view('quizzes.take', compact('quiz', 'questions'));
    }

    // Soumettre un quiz (Étudiant)
    public function submitQuiz(Request $request, $id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        $student = Auth::user();

        $request->validate([
            'answers' => 'required|array',
        ]);

        // Calculer le score
        $correctAnswers = 0;
        $totalQuestions = $quiz->questions->count();

        foreach ($quiz->questions as $question) {
            $userAnswer = $request->answers[$question->id] ?? null;
            if (is_numeric($userAnswer) && (int)$userAnswer === (int)$question->correct_answer) {
                $correctAnswers++;
            }
        }

        $score = ($totalQuestions > 0) ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        // Sauvegarder le résultat
        $result = \App\Models\QuizResult::create([
            'quiz_id' => $quiz->id,
            'student_id' => $student->id,
            'answers' => $request->answers,
            'score' => $score,
            'correct_answers' => $correctAnswers,
            'total_questions' => $totalQuestions,
        ]);

        return view('quizzes.result', compact('quiz', 'score', 'correctAnswers', 'totalQuestions', 'result'));
    }
}
