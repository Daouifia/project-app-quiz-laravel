<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz App - Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-600 to-blue-800">
    <div class="min-h-screen flex items-center justify-center">
        <div class="text-center text-white">
            <h1 class="text-5xl font-bold mb-4">Quiz App</h1>
            <p class="text-xl mb-8">Plateforme d'évaluation en ligne pour étudiants et professeurs</p>
            
            <div class="flex gap-4 justify-center">
                <a href="<?php echo e(route('login')); ?>" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Connexion
                </a>
                <a href="<?php echo e(route('register')); ?>" class="bg-green-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-600 transition">
                    Inscription
                </a>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\aouif\Desktop\finallaravel\backend\resources\views/welcome.blade.php ENDPATH**/ ?>