@extends('layouts.app')

@section('title', 'Tous les Quiz')

@section('content')
<div class="navbar">
    <div class="navbar-brand">Quiz App - {{ ucfirst(Auth::user()->role) }}</div>
    <div class="navbar-menu">
        @if(Auth::user()->role === 'professor')
            <a href="{{ route('professor.dashboard') }}" class="navbar-link">← Retour au Dashboard</a>
        @elseif(Auth::user()->role === 'student')
            <a href="{{ route('student.dashboard') }}" class="navbar-link">← Retour au Dashboard</a>
        @else
            <a href="{{ route('admin.dashboard') }}" class="navbar-link">← Retour au Dashboard</a>
        @endif
        <span style="color: #6b7280;">👤 {{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-secondary">🚪 Déconnexion</button>
        </form>
    </div>
</div>

<div class="container">
    <h1>📝 Tous les Quiz</h1>

    @if(Auth::user()->role === 'professor')
        <div style="margin-top: 30px; margin-bottom: 30px;">
            <a href="{{ route('quizzes.create') }}" class="btn btn-primary">➕ Créer un Quiz</a>
        </div>
    @endif

    <div class="dashboard-stats" style="margin-top: 30px;">
        <div class="stat-card">
            <p>Total Quiz</p>
            <h3>{{ $quizzes->count() }}</h3>
        </div>
    </div>

    <div style="margin-top: 30px;">
        @foreach($quizzes as $quiz)
        <div class="card" style="margin-bottom: 15px;">
            <h3 style="color: #667eea; margin-bottom: 10px;">{{ $quiz->title }}</h3>
            <p style="color: #6b7280; margin-bottom: 5px;">
                <strong>Professeur:</strong> {{ $quiz->professor->name }} ({{ $quiz->professor->email }})
            </p>
            <p style="color: #6b7280; margin-bottom: 5px;">
                <strong>Module:</strong> {{ $quiz->module }} | <strong>Groupe:</strong> {{ $quiz->groupe }}
            </p>
            <p style="color: #6b7280; margin-bottom: 5px;">
                <strong>Durée:</strong> {{ $quiz->duration }} minutes
            </p>
            <p style="color: #6b7280;">
                <strong>Questions:</strong> {{ $quiz->questions_count }} |
                <strong>Tentatives:</strong> {{ $quiz->results_count }}
            </p>
            @if(Auth::user()->role === 'student')
                @php
                    $hasTaken = \App\Models\QuizResult::where('quiz_id', $quiz->id)->where('student_id', Auth::id())->exists();
                @endphp
                    @if($hasTaken)
                    <p style="color: #10b981; font-weight: bold;">✅ Quiz déjà passé</p>
                @else
                    <a href="{{ route('quizzes.take', $quiz->id) }}" class="btn btn-primary" style="margin-top: 10px;">📝 Passer le Quiz</a>
                @endif
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection