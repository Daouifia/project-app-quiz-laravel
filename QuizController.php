<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    // Lister tous les quiz (professeur voit ses quiz, étudiant voit quiz de son module/groupe)
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'professor') {
            $quizzes = Quiz::where('professor_id', $user->id)
                ->withCount('questions')
                ->get();
        } elseif ($user->role === 'student') {
            $quizzes = Quiz::where('module', $user->module)
                ->where('groupe', $user->groupe)
                ->withCount('questions')
                ->get();
        } else {
            $quizzes = Quiz::withCount('questions')->get();
        }

        return response()->json([
            'success' => true,
            'quizzes' => $quizzes
        ]);
    }

    // Afficher un quiz avec ses questions
    public function show($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);

        return response()->json([
            'success' => true,
            'quiz' => $quiz
        ]);
    }

    // Créer un quiz
    public function store(Request $request)
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

        DB::beginTransaction();
        try {
            $quiz = Quiz::create([
                'professor_id' => $request->user()->id,
                'title' => $request->title,
                'duration' => $request->duration,
                'module' => $request->module,
                'groupe' => $request->groupe,
            ]);

            foreach ($request->questions as $questionData) {
                Question::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $questionData['question_text'],
                    'choices' => $questionData['choices'],
                    'correct_answer' => $questionData['correct_answer'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Quiz créé avec succès',
                'quiz' => $quiz->load('questions')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du quiz',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Modifier un quiz
    public function update(Request $request, $id)
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

        $quiz = Quiz::findOrFail($id);

        if ($quiz->professor_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Non autorisé'
            ], 403);
        }

        DB::beginTransaction();
        try {
            $quiz->update([
                'title' => $request->title,
                'duration' => $request->duration,
                'module' => $request->module,
                'groupe' => $request->groupe,
            ]);

            // Supprimer anciennes questions
            $quiz->questions()->delete();

            // Créer nouvelles questions
            foreach ($request->questions as $questionData) {
                Question::create([
                    'quiz_id' => $quiz->id,
                    'question_text' => $questionData['question_text'],
                    'choices' => $questionData['choices'],
                    'correct_answer' => $questionData['correct_answer'],
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Quiz modifié avec succès',
                'quiz' => $quiz->load('questions')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification du quiz',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Supprimer un quiz
    public function destroy(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        if ($quiz->professor_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Non autorisé'
            ], 403);
        }

        $quiz->delete();

        return response()->json([
            'success' => true,
            'message' => 'Quiz supprimé avec succès'
        ]);
    }

    // Soumettre un quiz (étudiant)
    public function submit(Request $request, $id)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);

        $quiz = Quiz::with('questions')->findOrFail($id);
        $student = $request->user();

        $correctAnswers = 0;
        $totalQuestions = $quiz->questions->count();
        $questionsDetail = [];

        foreach ($quiz->questions as $question) {
            $userAnswer = $request->answers[$question->id] ?? null;
            $isCorrect = $userAnswer === $question->correct_answer;

            if ($isCorrect) {
                $correctAnswers++;
            }

            $questionsDetail[] = [
                'question_text' => $question->question_text,
                'choices' => $question->choices,
                'user_answer' => $userAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect
            ];
        }

        $score = ($totalQuestions > 0) ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        $result = QuizResult::create([
            'quiz_id' => $quiz->id,
            'student_id' => $student->id,
            'answers' => $request->answers,
            'score' => $score,
            'correct_answers' => $correctAnswers,
            'total_questions' => $totalQuestions,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Quiz soumis avec succès',
            'result' => [
                'score' => $score,
                'correct_answers' => $correctAnswers,
                'total_questions' => $totalQuestions,
                'questions_detail' => $questionsDetail,
                'submitted_at' => $result->created_at
            ]
        ]);
    }

    // Résultats de l'étudiant
    public function studentResults(Request $request)
    {
        $student = $request->user();

        $results = QuizResult::where('student_id', $student->id)
            ->with('quiz')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($result) {
                $quiz = $result->quiz;
                $questions = $quiz->questions;

                $questionsDetail = [];
                foreach ($questions as $question) {
                    $userAnswer = $result->answers[$question->id] ?? null;
                    $questionsDetail[] = [
                        'question_text' => $question->question_text,
                        'choices' => $question->choices,
                        'user_answer' => $userAnswer,
                        'correct_answer' => $question->correct_answer,
                    ];
                }

                return [
                    'quiz_title' => $quiz->title,
                    'module' => $quiz->module,
                    'score' => $result->score,
                    'correct_answers' => $result->correct_answers,
                    'total_questions' => $result->total_questions,
                    'submitted_at' => $result->created_at,
                    'questions_detail' => $questionsDetail
                ];
            });

        return response()->json([
            'success' => true,
            'results' => $results
        ]);
    }

    // Statistiques d'un quiz (professeur)
    public function statistics($id)
    {
        $quiz = Quiz::with(['results.student'])->findOrFail($id);

        $totalAttempts = $quiz->results->count();
        $averageScore = $totalAttempts > 0 ? $quiz->results->avg('score') : 0;
        $highestScore = $totalAttempts > 0 ? $quiz->results->max('score') : 0;
        $lowestScore = $totalAttempts > 0 ? $quiz->results->min('score') : 0;

        $studentResults = $quiz->results->map(function ($result) {
            return [
                'student_name' => $result->student->name,
                'student_email' => $result->student->email,
                'score' => $result->score,
                'submitted_at' => $result->created_at
            ];
        });

        return response()->json([
            'success' => true,
            'statistics' => [
                'quiz_title' => $quiz->title,
                'total_attempts' => $totalAttempts,
                'average_score' => round($averageScore, 2),
                'highest_score' => $highestScore,
                'lowest_score' => $lowestScore,
                'student_results' => $studentResults
            ]
        ]);
    }
}