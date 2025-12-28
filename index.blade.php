<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Quiz App</h1>
            <div class="flex gap-4">
                @auth
                    <span class="text-sm">{{ Auth::user()->name }} ({{ Auth::user()->role }})</span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:underline">Déconnexion</button>
                    </form>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Quiz Disponibles</h2>
            @if (Auth::user()->role === 'professor')
                <a href="{{ route('quizzes.create') }}" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                    + Créer un Quiz
                </a>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($quizzes as $quiz)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $quiz->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4">
                            {{ $quiz->description ?? 'Pas de description' }}
                        </p>
                        
                        <div class="space-y-2 text-sm text-gray-700 mb-4">
                            <p><strong>Module:</strong> {{ $quiz->module }}</p>
                            <p><strong>Groupe:</strong> {{ $quiz->groupe }}</p>
                            <p><strong>Durée:</strong> {{ $quiz->duration }} minutes</p>
                            <p><strong>Prof:</strong> {{ $quiz->professor->name }}</p>
                        </div>

                        <div class="flex gap-2">
                            @if (Auth::user()->role === 'professor' && $quiz->professor_id === Auth::id())
                                <a href="{{ route('quizzes.edit', $quiz) }}" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center transition">
                                    Éditer
                                </a>
                                <a href="{{ route('quizzes.results', $quiz) }}" class="flex-1 bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700 text-center transition">
                                    Résultats
                                </a>
                            @else
                                <a href="{{ route('quizzes.take', $quiz) }}" class="flex-1 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-center transition">
                                    Commencer
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-600 text-lg">Aucun quiz disponible</p>
                </div>
            @endforelse
        </div>

        @if ($quizzes->hasPages())
            <div class="mt-8">
                {{ $quizzes->links() }}
            </div>
        @endif
    </div>
</body>
</html>
