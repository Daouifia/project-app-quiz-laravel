<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Quiz App</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes inputFocus {
            from { transform: scale(0.95); }
            to { transform: scale(1); }
        }
        .animate-slide-down { animation: slideInDown 0.6s ease-out; }
        .animate-fade { animation: fadeIn 0.8s ease-out; }
        .input-focus:focus { animation: inputFocus 0.2s ease-out; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center py-8">
    <!-- Background shapes -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-bl from-blue-400 to-transparent rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-gradient-to-tr from-indigo-400 to-transparent rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
    </div>

    <div class="relative z-10 bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 animate-slide-down">
        <div class="text-center mb-8">
            <div class="text-5xl mb-3">🎓</div>
            <h2 class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">Quiz App</h2>
            <p class="text-gray-600">Connectez-vous pour continuer</p>
        </div>
        
        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg mb-4 animate-fade">
                @foreach ($errors->all() as $error)
                    <p class="text-sm">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg mb-4 animate-fade">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email"
                    value="{{ old('email') }}"
                    placeholder="votre@email.com"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 input-focus"
                    required
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Mot de passe</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password"
                    placeholder="Entrez n'importe quel mot de passe"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 input-focus"
                    required
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 rounded-xl font-semibold hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105"
            >
                Se Connecter
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-center text-gray-600 text-sm">
                Pas de compte? <a href="{{ route('register') }}" class="text-blue-600 font-semibold hover:text-blue-700 transition">S'inscrire maintenant</a>
            </p>
        </div>
    </div>
</body>
</html>
