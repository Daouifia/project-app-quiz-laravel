<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Quiz App</title>
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
            <p class="text-gray-600">Créez votre compte pour commencer</p>
        </div>

        <?php if($errors->any()): ?>
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg mb-4 animate-fade">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p class="text-sm"><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('register')); ?>" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?>

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nom complet</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="<?php echo e(old('name')); ?>"
                    placeholder="Jean Dupont"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 input-focus"
                    required
                >
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    value="<?php echo e(old('email')); ?>"
                    placeholder="votre@email.com"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 input-focus"
                    required
                >
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Mot de passe</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    placeholder="Entrez un mot de passe"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 input-focus"
                    required
                >
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Confirmer mot de passe</label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation"
                    placeholder="Confirmez votre mot de passe"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 input-focus"
                    required
                >
            </div>

            <div>
                <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">Rôle</label>
                <select 
                    id="role" 
                    name="role" 
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 input-focus"
                    onchange="toggleFields()"
                    required
                >
                    <option value="">Sélectionnez un rôle</option>
                    <option value="professor" <?php echo e(old('role') === 'professor' ? 'selected' : ''); ?>>👨‍🏫 Professeur</option>
                    <option value="student" <?php echo e(old('role') === 'student' ? 'selected' : ''); ?>>👨‍🎓 Étudiant</option>
                </select>
            </div>

            <div id="module-field" class="hidden transition-all duration-300">
                <label for="module" class="block text-sm font-semibold text-gray-700 mb-2">Module</label>
                <input 
                    type="text" 
                    id="module" 
                    name="module" 
                    value="<?php echo e(old('module')); ?>"
                    placeholder="Ex: Mathématiques"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 input-focus"
                >
            </div>

            <div id="groupe-field" class="hidden transition-all duration-300">
                <label for="groupe" class="block text-sm font-semibold text-gray-700 mb-2">Groupe</label>
                <input 
                    type="text" 
                    id="groupe" 
                    name="groupe" 
                    value="<?php echo e(old('groupe')); ?>"
                    placeholder="Ex: Groupe A"
                    class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 input-focus"
                >
            </div>

            <button 
                type="submit" 
                class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold py-3 rounded-xl hover:shadow-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105"
            >
                S'inscrire
            </button>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-200">
            <p class="text-center text-gray-600 text-sm">
                Déjà inscrit? <a href="<?php echo e(route('login')); ?>" class="text-blue-600 font-semibold hover:text-blue-700 transition">Se connecter maintenant</a>
            </p>
        </div>
    </div>

    <script>
        function toggleFields() {
            const role = document.getElementById('role').value;
            const moduleField = document.getElementById('module-field');
            const groupeField = document.getElementById('groupe-field');

            if (role === 'professor') {
                moduleField.classList.remove('hidden');
                groupeField.classList.add('hidden');
            } else if (role === 'student') {
                moduleField.classList.add('hidden');
                groupeField.classList.remove('hidden');
            } else {
                moduleField.classList.add('hidden');
                groupeField.classList.add('hidden');
            }
        }

        // Initialiser au chargement
        toggleFields();
    </script>
</body>
</html>
<?php /**PATH C:\Users\aouif\Desktop\finallaravel\backend\resources\views/auth/register.blade.php ENDPATH**/ ?>