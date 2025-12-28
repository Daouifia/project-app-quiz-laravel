<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->title }} - Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slide { animation: slideIn 0.5s ease-out; }
        .answer-selected { background: #dbeafe !important; border: 2px solid #3b82f6 !important; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .progress-bar { transition: width 0.3s ease; }
        .feedback-correct { background: #d1fae5; border-left: 4px solid #10b981; }
        .feedback-wrong { background: #fee2e2; border-left: 4px solid #ef4444; }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">{{ $quiz->title }}</h1>
                <p class="text-blue-100 text-sm">Module: {{ $quiz->module }}</p>
            </div>
            <div class="text-right">
                <p class="text-lg font-semibold">⏱️ {{ $quiz->duration }} min</p>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8 max-w-3xl">
        <!-- Progress Bar -->
        <div class="mb-8 animate-slide">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-semibold text-gray-700">Progression</span>
                <span id="progress-count" class="text-sm font-semibold text-blue-600">0/{{ $questions->count() }}</span>
            </div>
            <div class="w-full bg-gray-300 rounded-full h-3 overflow-hidden">
                <div id="progress-bar" class="progress-bar bg-gradient-to-r from-blue-500 to-indigo-600 h-full rounded-full" style="width: 0%"></div>
            </div>
        </div>

        <form id="quizForm" action="{{ route('quizzes.submit', $quiz->id) }}" method="POST">
            @csrf

            @foreach ($questions as $index => $question)
                <div class="mb-8 animate-slide" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="bg-white rounded-xl shadow-lg p-8 hover:shadow-xl transition-shadow duration-300">
                        <!-- Question Header -->
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex-1">
                                <span class="inline-block px-4 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold mb-2">
                                    Question {{ $index + 1 }}/{{ $questions->count() }}
                                </span>
                                <h3 class="text-xl font-bold text-gray-800 mt-2">
                                    {{ $question->question_text }}
                                </h3>
                            </div>
                        </div>

                        <!-- Answer Options -->
                        <div class="space-y-3">
                            @foreach ($question->choices as $idx => $option)
                                <label class="answer-option block cursor-pointer transition-all duration-200" data-question="{{ $question->id }}" data-answer="{{ $idx }}" data-correct="{{ $question->correct_answer }}">
                                    <input 
                                        type="radio" 
                                        name="answers[{{ $question->id }}]" 
                                        value="{{ $idx }}"
                                        class="hidden"
                                        onchange="handleAnswerChange()"
                                    >
                                    <div class="flex items-center p-4 border-2 border-gray-300 rounded-lg hover:border-blue-400 hover:bg-blue-50 transition-all duration-200">
                                        <div class="w-5 h-5 rounded-full border-2 border-gray-400 flex items-center justify-center mr-4 transition-all">
                                            <div class="w-3 h-3 rounded-full bg-blue-600 opacity-0 transition-opacity"></div>
                                        </div>
                                        <span class="text-gray-700 font-medium flex-1">{{ $option }}</span>
                                    </div>
                                </label>
                            @endforeach
                        </div>

                        <!-- Feedback Message -->
                        <div id="feedback-{{ $question->id }}" class="feedback-message hidden mt-4 p-4 rounded-lg text-sm font-semibold animate-slide">
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Submit Button -->
            <div class="flex gap-4 mt-12 mb-8">
                <button 
                    type="submit" 
                    id="submitBtn"
                    class="flex-1 bg-gradient-to-r from-green-500 to-green-600 text-white font-bold py-4 rounded-xl hover:shadow-lg hover:from-green-600 hover:to-green-700 transition-all duration-300 transform hover:scale-105"
                >
                    ✓ Soumettre le Quiz
                </button>
                <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-600 text-white font-bold py-4 rounded-xl hover:bg-gray-700 hover:shadow-lg transition-all duration-300 text-center">
                    ← Retour
                </a>
            </div>
        </form>
    </div>

    <script>
        const totalQuestions = {{ $questions->count() }};
        const quizQuestions = {!! json_encode($questions->map(fn($q) => ['id' => $q->id, 'correct' => $q->correct_answer, 'choices' => $q->choices])->toArray()) !!};

        function handleAnswerChange() {
            const answered = document.querySelectorAll('input[type="radio"]:checked').length;
            updateProgress(answered);
            showFeedback();
        }

        function updateProgress(answered) {
            const percentage = (answered / totalQuestions) * 100;
            document.getElementById('progress-bar').style.width = percentage + '%';
            document.getElementById('progress-count').textContent = answered + '/' + totalQuestions;
        }

        function showFeedback() {
            document.querySelectorAll('.answer-option').forEach(option => {
                const input = option.querySelector('input[type="radio"]');
                const qId = option.dataset.question;
                const answer = parseInt(option.dataset.answer);
                const correct = parseInt(option.dataset.correct);
                const feedback = document.getElementById('feedback-' + qId);
                const label = option.querySelector('div');
                const radioCircle = label.querySelector('.w-3');

                if (input.checked) {
                    label.classList.add('answer-selected');
                    radioCircle.classList.add('opacity-100');
                    
                    if (answer === correct) {
                        feedback.classList.remove('hidden', 'feedback-wrong', 'text-red-700');
                        feedback.classList.add('feedback-correct', 'text-green-700');
                        feedback.textContent = '✓ Correct!';
                    } else {
                        feedback.classList.remove('hidden', 'feedback-correct', 'text-green-700');
                        feedback.classList.add('feedback-wrong', 'text-red-700');
                        const question = quizQuestions.find(q => q.id == qId);
                        const correctText = question ? question.choices[correct] : 'N/A';
                        feedback.textContent = '✗ Incorrect. Bonne réponse: ' + correctText;
                    }
                } else {
                    label.classList.remove('answer-selected');
                    radioCircle.classList.remove('opacity-100');
                    feedback.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
