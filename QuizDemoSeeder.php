<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuizDemoSeeder extends Seeder
{
    public function run()
    {
        // Create users
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com'
        ],[
            'name' => 'Admin',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        $prof = User::firstOrCreate([
            'email' => 'professor@example.com'
        ],[
            'name' => 'Professeur',
            'password' => bcrypt('password'),
            'role' => 'professor'
        ]);

        // Create students
        for ($i=1; $i<=5; $i++) {
            User::firstOrCreate([
                'email' => "student{$i}@example.com"
            ],[
                'name' => "Etudiant {$i}",
                'password' => bcrypt('password'),
                'role' => 'student',
                'groupe' => 'Groupe ' . chr(64 + ($i%5)+1)
            ]);
        }

        // Create 4 quizzes (modules)
        $modules = ['Mathematiques','Physique','Informatique','Chimie'];
        $groups = ['Groupe A','Groupe B','Groupe C','Groupe D','Groupe E'];
        foreach ($modules as $idx => $module) {
            foreach ($groups as $groupe) {
                $quiz = Quiz::firstOrCreate([
                    'title' => "Quiz de {$module} - {$groupe}"
                ],[
                    'professor_id' => $prof->id,
                    'description' => "Quiz introductif sur {$module} pour {$groupe}",
                    'duration' => 15 + $idx*5,
                    'module' => $module,
                    'groupe' => $groupe,
                ]);

                // 3 questions per quiz
                for ($q=1;$q<=3;$q++){
                    $choices = ["Option A","Option B","Option C","Option D"];
                    $correctIndex = array_rand($choices);
                    Question::firstOrCreate([
                        'quiz_id' => $quiz->id,
                        'question_text' => "Question {$q} du {$module} ?"
                    ],[
                        'choices' => $choices,
                        'correct_answer' => $correctIndex,
                    ]);
                }
            }
        }
    }
}
