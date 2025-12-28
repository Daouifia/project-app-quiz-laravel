<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - Quiz App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white p-6">
            <div class="mb-8">
                <h1 class="text-2xl font-bold">Quiz App</h1>
            </div>
            <nav class="space-y-4">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2 rounded bg-blue-600">Dashboard</a>
                <a href="{{ route('student.results') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Mes Résultats</a>
            </nav>
            <div class="mt-8 pt-8 border-t border-gray-700">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full text-left px-4 py-2 rounded hover:bg-gray-700">Déconnexion</button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 overflow-auto">
            <div class="p-8">
                <div class="mb-8">
                    <h2 class="text-3xl font-bold text-gray-800">Quizzes Disponibles</h2>
                    <p class="text-gray-600 mt-2">Sélectionnez un quiz pour commencer</p>
                </div>

                <!-- Quizzes Grid -->
                <div class="grid grid-cols-3 gap-6">
                    @forelse($quizzes as $quiz)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition cursor-pointer" onclick="location.href='{{ route('quizzes.take', $quiz->id) }}'">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-800">{{ $quiz->title }}</h3>
                            <p class="text-gray-600 text-sm mt-2">{{ $quiz->module ?? 'N/A' }} - Groupe {{ $quiz->groupe ?? 'N/A' }}</p>
                            <div class="mt-4 space-y-2">
                                <p class="text-sm text-gray-600">
                                    <strong>Questions:</strong> {{ $quiz->questions->count() ?? 0 }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    <strong>Durée:</strong> {{ $quiz->duration ?? 'N/A' }} minutes
                                </p>
                            </div>
                            <button class="mt-4 w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">
                                Commencer →
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-3 text-center py-8">
                        <p class="text-gray-600">Aucun quiz disponible</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</body>
</html>
