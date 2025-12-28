<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Quiz App</title>
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
                <a href="{{ route('admin.quizzes') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Tous les Quizzes</a>
                <a href="{{ route('admin.users') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Utilisateurs</a>
                <a href="{{ route('admin.modules') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Modules</a>
                <a href="{{ route('admin.groupes') }}" class="block px-4 py-2 rounded hover:bg-gray-700">Groupes</a>
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
                    <h2 class="text-3xl font-bold text-gray-800">Dashboard Admin</h2>
                    <p class="text-gray-600 mt-2">Bienvenue, {{ Auth::user()->name }}</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-gray-500 text-sm font-medium">Total Utilisateurs</div>
                        <div class="text-3xl font-bold mt-2">{{ $totalUsers }}</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-gray-500 text-sm font-medium">Total Quizzes</div>
                        <div class="text-3xl font-bold mt-2">{{ $totalQuizzes }}</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-gray-500 text-sm font-medium">Modules</div>
                        <div class="text-3xl font-bold mt-2">{{ $totalModules }}</div>
                    </div>
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="text-gray-500 text-sm font-medium">Groupes</div>
                        <div class="text-3xl font-bold mt-2">{{ $totalGroupes }}</div>
                    </div>
                </div>

                <!-- Recent Quizzes -->
                <div class="bg-white rounded-lg shadow">
                    <div class="border-b border-gray-200 p-6">
                        <h3 class="text-lg font-semibold">Quizzes Récents</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Titre</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Module</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Groupe</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Durée</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentQuizzes as $quiz)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $quiz->title }}</td>
                                    <td class="px-6 py-4">{{ $quiz->module ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $quiz->groupe ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $quiz->duration ?? 'N/A' }} min</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
