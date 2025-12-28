<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat - Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes bounceIn {
            0% { transform: scale(0.3); opacity: 0; }
            50% { opacity: 1; }
            70% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .animate-slide { animation: slideIn 0.6s ease-out; }
        .animate-bounce-in { animation: bounceIn 0.6s ease-out; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen py-8">
    <div class="container mx-auto px-4 max-w-2xl">
        <!-- Score Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 mb-8 animate-slide">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $quiz->title }}</h1>
                <p class="text-gray-600">Module: <span class="font-semibold">{{ $quiz->module }}</span></p>
            </div>

            <!-- Score Visualization -->
            <div class="flex justify-center mb-8">
                <div class="relative w-40 h-40 animate-bounce-in">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 200 200">
                        <!-- Background Circle -->
                        <circle cx="100" cy="100" r="90" fill="none" stroke="#e5e7eb" stroke-width="12"/>
                        <!-- Progress Circle -->
                        <circle 
                            cx="100" 
                            cy="100" 
                            r="90" 
                            fill="none" 
                            stroke="url(#scoreGradient)" 
                            stroke-width="12"
                            stroke-dasharray="{{ ($score / 100) * 565 }} 565"
                            style="transition: stroke-dasharray 1s ease-out;"
                        />
                        <defs>
                            <linearGradient id="scoreGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color: #10b981; stop-opacity: 1" />
                                <stop offset="100%" style="stop-color: #059669; stop-opacity: 1" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <p class="text-5xl font-bold text-green-600">{{ $score }}%</p>
                            <p class="text-sm text-gray-500 mt-1">Score</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 text-center">
                    <p class="text-4xl font-bold text-green-600">{{ $correct_answers }}</p>
                    <p class="text-sm text-gray-700 mt-2">Correctes</p>
                </div>
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 text-center">
                    <p class="text-4xl font-bold text-red-600">{{ $total_questions - $correct_answers }}</p>
                    <p class="text-sm text-gray-700 mt-2">Incorrectes</p>
                </div>
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 text-center">
                    <p class="text-4xl font-bold text-blue-600">{{ $total_questions }}</p>
                    <p class="text-sm text-gray-700 mt-2">Total</p>
                </div>
            </div>

            <!-- Result Message -->
            <div class="mb-8">
                @php
                    $message = '';
                    $emoji = '';
                    
                    if ($score >= 80) {
                        $message = 'Excellent! Vous maîtrisez bien ce sujet!';
                        $emoji = '🎉';
                    } elseif ($score >= 60) {
                        $message = 'Bien joué! Continuez vos efforts!';
                        $emoji = '👏';
                    } elseif ($score >= 40) {
                        $message = 'Pas mal! Révisez les points faibles.';
                        $emoji = '💪';
                    } else {
                        $message = 'Il faut revoir ce chapitre. Persévérez!';
                        $emoji = '📚';
                    }
                @endphp
                
                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
                    <p class="text-2xl font-bold text-blue-700 mb-2">{{ $emoji }} {{ $message }}</p>
                    <p class="text-gray-700">Vous avez obtenu <span class="font-semibold">{{ $correct_answers }}/{{ $total_questions }}</span> bonnes réponses.</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col gap-3">
                <a 
                    href="{{ route('student.results') }}" 
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-bold py-4 rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 text-center"
                >
                    📊 Voir Mes Résultats
                </a>
                <a 
                    href="{{ route('dashboard') }}" 
                    class="w-full bg-gray-600 text-white font-bold py-4 rounded-xl hover:bg-gray-700 hover:shadow-lg transition-all duration-300 text-center"
                >
                    ← Retour au Dashboard
                </a>
            </div>
        </div>
    </div>
</body>
</html>
