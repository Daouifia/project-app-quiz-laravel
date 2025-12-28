<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer le Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">Quiz App</h1>
            <a href="{{ route('quizzes.index') }}" class="hover:underline">Retour</a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-3xl font-bold mb-8">Éditer le Quiz: {{ $quiz->title }}</h2>

            <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                <form action="{{ route('quizzes.update', $quiz) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 font-semibold mb-2">Titre</label>
                        <input 
                            type="text" 
                            id="title" 
                            name="title" 
                            value="{{ old('title', $quiz->title) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                        >
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                        >{{ old('description', $quiz->description) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="duration" class="block text-gray-700 font-semibold mb-2">Durée (minutes)</label>
                        <input 
                            type="number" 
                            id="duration" 
                            name="duration" 
                            value="{{ old('duration', $quiz->duration) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                        >
                    </div>

                    <div class="mb-4">
                        <label for="module" class="block text-gray-700 font-semibold mb-2">Module</label>
                        <input 
                            type="text" 
                            id="module" 
                            name="module" 
                            value="{{ old('module', $quiz->module) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                        >
                    </div>

                    <div class="mb-6">
                        <label for="groupe" class="block text-gray-700 font-semibold mb-2">Groupe</label>
                        <input 
                            type="text" 
                            id="groupe" 
                            name="groupe" 
                            value="{{ old('groupe', $quiz->groupe) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg"
                        >
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            Mettre à jour
                        </button>
                        <a href="{{ route('quizzes.show', $quiz) }}" class="bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-lg shadow-md p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold">Questions ({{ $questions->count() }})</h3>
                    <a href="{{ route('quizzes.addQuestion', $quiz) }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        + Ajouter une Question
                    </a>
                </div>

                @if ($questions->isEmpty())
                    <p class="text-gray-600">Aucune question pour ce quiz. Ajoutez-en une!</p>
                @else
                    <div class="space-y-4">
                        @foreach ($questions as $question)
                            <div class="p-4 border border-gray-300 rounded-lg bg-gray-50">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-semibold">{{ $question->question_text }}</h4>
                                    <div class="flex gap-2">
                                        <a href="{{ route('quizzes.editQuestion', $question) }}" class="text-blue-600 hover:underline text-sm">
                                            Éditer
                                        </a>
                                        <form action="{{ route('quizzes.deleteQuestion', $question) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm" onclick="return confirm('Êtes-vous sûr?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600">Bonne réponse: <strong>{{ $question->correct_answer }}</strong></p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
