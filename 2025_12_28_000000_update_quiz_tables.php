<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            if (!Schema::hasColumn('quizzes', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
        });

        Schema::table('questions', function (Blueprint $table) {
            if (!Schema::hasColumn('questions', 'options')) {
                $table->json('options')->nullable()->after('question_text');
            }
            if (!Schema::hasColumn('questions', 'correct_answer')) {
                $table->string('correct_answer')->after('options');
            }
            // Optionnel: Supprimer les anciennes colonnes si elles existent
        });

        Schema::table('quiz_results', function (Blueprint $table) {
            if (!Schema::hasColumn('quiz_results', 'total')) {
                $table->integer('total')->default(0)->after('score');
            }
            if (!Schema::hasColumn('quiz_results', 'percentage')) {
                $table->float('percentage')->default(0)->after('total');
            }
        });
    }

    public function down(): void
    {
        Schema::table('quizzes', function (Blueprint $table) {
            if (Schema::hasColumn('quizzes', 'description')) {
                $table->dropColumn('description');
            }
        });

        Schema::table('questions', function (Blueprint $table) {
            if (Schema::hasColumn('questions', 'options')) {
                $table->dropColumn('options');
            }
        });

        Schema::table('quiz_results', function (Blueprint $table) {
            if (Schema::hasColumn('quiz_results', 'total')) {
                $table->dropColumn('total');
            }
            if (Schema::hasColumn('quiz_results', 'percentage')) {
                $table->dropColumn('percentage');
            }
        });
    }
};
