<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Quiz App</h1>
            <a href="{{ route('quizzes.index') }}" class="hover:underline">Retour</a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow-md p-8">
            <h2 class="text-3xl font-bold mb-2">{{ $quiz->title }}</h2>
            <p class="text-gray-600 mb-6">{{ $quiz->description }}</p>

            <div class="grid grid-cols-2 gap-4 mb-8 p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm text-gray-600">Module</p>
                    <p class="font-semibold">{{ $quiz->module }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Groupe</p>
                    <p class="font-semibold">{{ $quiz->groupe }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Durée</p>
                    <p class="font-semibold">{{ $quiz->duration }} min</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Professeur</p>
                    <p class="font-semibold">{{ $quiz->professor->name }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Nombre de Questions</p>
                    <p class="font-semibold">{{ $questions->count() }}</p>
                </div>
            </div>

            @if (Auth::user()->role === 'professor' && $quiz->professor_id === Auth::id())
                <div class="flex gap-4">
                    <a href="{{ route('quizzes.edit', $quiz) }}" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition text-center">
                        Éditer le Quiz
                    </a>
                    <a href="{{ route('quizzes.results', $quiz) }}" class="flex-1 bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition text-center">
                        Voir les Résultats
                    </a>
                    <form action="{{ route('quizzes.destroy', $quiz) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition" onclick="return confirm('Êtes-vous sûr?')">
                            Supprimer
                        </button>
                    </form>
                </div>
            @else
                <div class="flex gap-4">
                    <a href="{{ route('quizzes.take', $quiz) }}" class="flex-1 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition text-center font-semibold">
                        Commencer le Quiz
                    </a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
