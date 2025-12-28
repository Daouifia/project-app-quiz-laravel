<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats du Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <nav class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">{{ $quiz->title }}</h1>
            <a href="{{ route('quizzes.index') }}" class="hover:underline">Retour</a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <h2 class="text-3xl font-bold mb-8">Résultats - {{ $quiz->title }}</h2>

        @if ($results->isEmpty())
            <div class="bg-white rounded-lg shadow-md p-8 text-center">
                <p class="text-gray-600 text-lg">Aucun résultat pour ce quiz</p>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="w-full">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left">Étudiant</th>
                            <th class="px-6 py-3 text-left">Score</th>
                            <th class="px-6 py-3 text-left">Pourcentage</th>
                            <th class="px-6 py-3 text-left">Date</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-3">{{ $result->student->name }}</td>
                                <td class="px-6 py-3">{{ $result->score }}/{{ $result->total }}</td>
                                <td class="px-6 py-3">
                                    <span class="px-3 py-1 rounded {{ $result->percentage >= 50 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ number_format($result->percentage, 1) }}%
                                    </span>
                                </td>
                                <td class="px-6 py-3">{{ $result->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-6 py-3">
                                    <a href="{{ route('quizzes.result', $result) }}" class="text-blue-600 hover:underline">
                                        Voir détails
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if ($results->hasPages())
                <div class="mt-8">
                    {{ $results->links() }}
                </div>
            @endif
        @endif
    </div>
</body>
</html>
