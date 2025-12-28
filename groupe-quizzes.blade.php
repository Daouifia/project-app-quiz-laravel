@extends('layouts.app')

@section('title', 'Quiz - Groupe ' . $groupe)

@section('content')
<div class="navbar">
    <div class="navbar-brand">Quiz App - {{ ucfirst(Auth::user()->role) }}</div>
    <div class="navbar-menu">
        @if(Auth::user()->role === 'professor')
            <a href="{{ route('professor.groupes') }}" class="navbar-link">← Retour aux Groupes</a>
        @elseif(Auth::user()->role === 'student')
            <a href="{{ route('student.groupes') }}" class="navbar-link">← Retour aux Groupes</a>
        @else
            <a href="{{ route('admin.groupes') }}" class="navbar-link">← Retour aux Groupes</a>
        @endif
        <span style="color: #6b7280;">👤 {{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-secondary">🚪 Déconnexion</button>
        </form>
    </div>
</div>

<div class="container">
    <h1>👨‍👩‍👧‍👦 Groupe: {{ $groupe }}</h1>

    <div class="dashboard-stats" style="margin-top: 30px;">
        <div class="stat-card">
            <p>Quiz dans ce groupe</p>
            <h3>{{ $quizzes->count() }}</h3>
        </div>
        <div class="stat-card">
            <p>Modules</p>
            <h3>{{ $quizzes->pluck('module')->unique()->count() }}</h3>
        </div>
    </div>

    <div class="card" style="margin-top: 30px;">
        <h3 style="margin-bottom: 15px; color: #667eea;">Modules disponibles</h3>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            @foreach($quizzes->pluck('module')->unique() as $module)
            <span style="padding: 8px 16px; background: #667eea; color: white; border-radius: 20px; font-size: 14px; font-weight: 600;">
                📚 {{ $module }}
            </span>
            @endforeach
        </div>
    </div>

    <div style="margin-top: 30px;">
        <h3 style="margin-bottom: 20px; color: #667eea;">Quiz disponibles</h3>
        
        @if($quizzes->count() === 0)
        <div class="card">
            <p style="text-align: center; color: #6b7280;">
                Aucun quiz disponible pour ce groupe.
            </p>
        </div>
        @else
        @foreach($quizzes as $quiz)
        <div class="card" style="margin-bottom: 15px;">
            <h3 style="color: #667eea; margin-bottom: 10px;">{{ $quiz->title }}</h3>
            <p style="color: #6b7280; margin-bottom: 5px;">
                <strong>Module:</strong> {{ $quiz->module }}
            </p>
            <p style="color: #6b7280; margin-bottom: 5px;">
                <strong>Durée:</strong> {{ $quiz->duration }} minutes
            </p>
            <p style="color: #6b7280;">
                <strong>Questions:</strong> {{ $quiz->questions_count }} | 
                <strong>Tentatives:</strong> {{ $quiz->results_count }}
            </p>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection