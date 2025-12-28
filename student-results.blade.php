<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Résultats - Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .animate-slide { animation: slideIn 0.5s ease-out; }
        .result-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        .result-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }
        .score-good { border-l-4 border-green-500; background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, transparent 100%); }
        .score-ok { border-l-4 border-blue-500; background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, transparent 100%); }
        .score-bad { border-l-4 border-red-500; background: linear-gradient(135deg, rgba(239, 68, 68, 0.05) 0%, transparent 100%); }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen py-8">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Mes Résultats</h1>
            <a href="{{ route('dashboard') }}" class="text-blue-100 hover:text-white transition">← Retour au Dashboard</a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 max-w-5xl">
        @if ($results->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center animate-slide">
                <div class="text-6xl mb-4">📝</div>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Aucun résultat yet</h2>
                <p class="text-gray-600 mb-6">Vous n'avez pas encore passé de quiz. Commencez maintenant!</p>
                <a href="{{ route('dashboard') }}" class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold px-8 py-3 rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300">
                    Voir les Quizzes Disponibles
                </a>
            </div>
        @else
            <!-- Statistics Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 animate-slide">
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="text-4xl font-bold text-blue-600">{{ $results->count() }}</p>
                    <p class="text-gray-600 text-sm mt-2">Quiz Passés</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="text-4xl font-bold text-green-600">{{ round($results->avg('score')) }}%</p>
                    <p class="text-gray-600 text-sm mt-2">Score Moyen</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="text-4xl font-bold text-purple-600">{{ $results->max('score') }}%</p>
                    <p class="text-gray-600 text-sm mt-2">Meilleur Score</p>
                </div>
                <div class="bg-white rounded-xl shadow p-6 text-center">
                    <p class="text-4xl font-bold text-orange-600">{{ $results->min('score') }}%</p>
                    <p class="text-gray-600 text-sm mt-2">Plus Faible Score</p>
                </div>
            </div>

            <!-- Results Cards -->
            <div class="space-y-4">
                @foreach ($results as $index => $result)
                    @php
                        $scoreClass = $result->score >= 80 ? 'score-good' : ($result->score >= 60 ? 'score-ok' : 'score-bad');
                        $scoreColor = $result->score >= 80 ? 'text-green-600' : ($result->score >= 60 ? 'text-blue-600' : 'text-red-600');
                    @endphp
                    <div class="bg-white rounded-xl shadow-md p-6 result-card {{ $scoreClass }} animate-slide" style="animation-delay: {{ $index * 0.1 }}s;">
                        <div class="flex items-center justify-between">
                            <!-- Left Content -->
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $result->quiz->title }}</h3>
                                <div class="flex flex-wrap gap-3 text-sm text-gray-600">
                                    <span>📚 {{ $result->quiz->module }}</span>
                                    <span>👥 {{ $result->quiz->groupe }}</span>
                                    <span>📅 {{ $result->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                            </div>

                            <!-- Score Display -->
                            <div class="ml-6 flex items-center gap-4">
                                <div class="text-right">
                                    <p class="{{ $scoreColor }} text-4xl font-bold">{{ $result->score }}%</p>
                                    <p class="text-gray-600 text-sm">{{ $result->correct_answers }}/{{ $result->total_questions }}</p>
                                </div>

                                <!-- Score Badge -->
                                <div class="hidden md:flex items-center justify-center w-16 h-16 rounded-full {{ $scoreClass }} text-sm font-bold {{ $scoreColor }}">
                                    @if ($result->score >= 80)
                                        🎆
                                    @elseif ($result->score >= 60)
                                        👏
                                    @else
                                        📚
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
