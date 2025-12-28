<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Support\Facades\Hash;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer un professeur
        $professor = User::create([
            'name' => 'Professeur Test',
            'email' => 'prof@test.com',
            'password' => Hash::make('password123'),
            'role' => 'professor',
            'module' => 'Mathématiques',
            'groupe' => null,
        ]);

        // Créer des étudiants
        $student1 = User::create([
            'name' => 'Étudiant 1',
            'email' => 'student1@test.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'module' => null,
            'groupe' => 'Groupe A',
        ]);

        $student2 = User::create([
            'name' => 'Étudiant 2',
            'email' => 'student2@test.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'module' => null,
            'groupe' => 'Groupe B',
        ]);

        // Créer un quiz
        $quiz = Quiz::create([
            'professor_id' => $professor->id,
            'title' => 'Quiz Mathématiques - Les Fonctions',
            'description' => 'Questions sur les fonctions mathématiques basiques',
            'duration' => 30,
            'module' => 'Mathématiques',
            'groupe' => 'Groupe A',
        ]);

        // Ajouter des questions
        Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Quel est le résultat de 2 + 2?',
            'options' => json_encode(['3', '4', '5', '6']),
            'correct_answer' => '4',
        ]);

        Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Quelle est la dérivée de x²?',
            'options' => json_encode(['x', '2x', '2x²', 'x/2']),
            'correct_answer' => '2x',
        ]);

        Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Quelle est l\'intégrale de 2x?',
            'options' => json_encode(['x²', '2x²', 'x² + C', '2x + C']),
            'correct_answer' => 'x² + C',
        ]);

        Question::create([
            'quiz_id' => $quiz->id,
            'question_text' => 'Une fonction est continue si...',
            'options' => json_encode([
                'elle est définie partout',
                'on peut la tracer sans lever le stylo',
                'elle est dérivable',
                'elle est croissante'
            ]),
            'correct_answer' => 'on peut la tracer sans lever le stylo',
        ]);

        // Créer un autre quiz
        $quiz2 = Quiz::create([
            'professor_id' => $professor->id,
            'title' => 'Quiz Mathématiques - Géométrie',
            'description' => 'Questions sur la géométrie de base',
            'duration' => 20,
            'module' => 'Mathématiques',
            'groupe' => 'Groupe B',
        ]);

        Question::create([
            'quiz_id' => $quiz2->id,
            'question_text' => 'Quel est le théorème de Pythagore?',
            'options' => json_encode([
                'a + b = c',
                'a² + b² = c²',
                'a² + b = c²',
                'a + b² = c'
            ]),
            'correct_answer' => 'a² + b² = c²',
        ]);

        Question::create([
            'quiz_id' => $quiz2->id,
            'question_text' => 'Quelle est la formule du périmètre d\'un cercle?',
            'options' => json_encode(['πr', '2πr', 'πr²', '2πr²']),
            'correct_answer' => '2πr',
        ]);

        echo "✅ Seeder exécuté avec succès!\n";
        echo "Professeur: prof@test.com / password123\n";
        echo "Étudiant 1: student1@test.com / password123\n";
        echo "Étudiant 2: student2@test.com / password123\n";
    }
}
