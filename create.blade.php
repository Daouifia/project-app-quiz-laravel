<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Quiz</title>
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
        <div class="bg-white rounded-lg shadow-md p-8 max-w-2xl mx-auto">
            <h2 class="text-3xl font-bold mb-6">Créer un Nouveau Quiz</h2>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('quizzes.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold mb-2">Titre du Quiz *</label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                    >{{ old('description') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="duration" class="block text-gray-700 font-semibold mb-2">Durée (minutes) *</label>
                    <input 
                        type="number" 
                        id="duration" 
                        name="duration" 
                        value="{{ old('duration') }}"
                        min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label for="module" class="block text-gray-700 font-semibold mb-2">Module *</label>
                    <input 
                        type="text" 
                        id="module" 
                        name="module" 
                        value="{{ old('module', Auth::user()->module) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        required
                    >
                </div>

                <div class="mb-6">
                    <label for="groupe" class="block text-gray-700 font-semibold mb-2">Groupe *</label>
                    <input 
                        type="text" 
                        id="groupe" 
                        name="groupe" 
                        value="{{ old('groupe') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"
                        required
                    >
                </div>

                <div class="flex gap-4">
                    <button 
                        type="submit" 
                        class="bg-blue-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-blue-700 transition"
                    >
                        Créer le Quiz
                    </button>
                    <a href="{{ route('quizzes.index') }}" class="bg-gray-600 text-white font-semibold px-6 py-2 rounded-lg hover:bg-gray-700 transition">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
