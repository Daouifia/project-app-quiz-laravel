@extends('layouts.app')

@section('title', 'Quiz - ' . $module)

@section('content')
<div class="navbar">
    <div class="navbar-brand">Quiz App - {{ ucfirst(Auth::user()->role) }}</div>
    <div class="navbar-menu">
        @if(Auth::user()->role === 'professor')
            <a href="{{ route('professor.modules') }}" class="navbar-link">← Retour aux Modules</a>
        @elseif(Auth::user()->role === 'student')
            <a href="{{ route('student.modules') }}" class="navbar-link">← Retour aux Modules</a>
        @else
            <a href="{{ route('admin.modules') }}" class="navbar-link">← Retour aux Modules</a>
        @endif
        <span style="color: #6b7280;">👤 {{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-secondary">🚪 Déconnexion</button>
        </form>
    </div>
</div>

<div class="container">
    <h1>📚 Module: {{ $module }}</h1>

    <div class="dashboard-stats" style="margin-top: 30px;">
        <div class="stat-card">
            <p>Quiz dans ce module</p>
            <h3>{{ $quizzes->count() }}</h3>
        </div>
    </div>

    <div style="margin-top: 30px;">
        <h3 style="margin-bottom: 20px; color: #667eea;">Quiz disponibles</h3>
        
        @if($quizzes->count() === 0)
        <div class="card">
            <p style="text-align: center; color: #6b7280;">
                Aucun quiz disponible pour ce module.
            </p>
        </div>
        @else
        @foreach($quizzes as $quiz)
        <div class="card" style="margin-bottom: 15px;">
            <h3 style="color: #667eea; margin-bottom: 10px;">{{ $quiz->title }}</h3>
            <p style="color: #6b7280; margin-bottom: 5px;">
                <strong>Groupe:</strong> {{ $quiz->groupe }}
            </p>
            <p style="color: #6b7280; margin-bottom: 5px;">
                <strong>Durée:</strong> {{ $quiz->duration }} minutes
            </p>
            <p style="color: #6b7280;">
                <strong>Questions:</strong> {{ $quiz->questions_count }} | 
                <strong>Tentatives:</strong> {{ $quiz->results_count }}
            </p>
            <div style="margin-top:10px;">
                <a href="{{ route('quizzes.take', $quiz->id) }}" class="btn btn-primary">📝 Passer le Quiz</a>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection