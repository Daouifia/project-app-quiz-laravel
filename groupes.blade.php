@extends('layouts.app')

@section('title', 'Tous les Groupes')

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
    <h1>👨‍👩‍👧‍👦 Tous les Groupes</h1>

    <div class="dashboard-stats" style="margin-top: 30px;">
        <div class="stat-card">
            <p>Total Groupes</p>
            <h3>{{ $groupes->count() }}</h3>
        </div>
    </div>

    <div style="margin-top: 30px; display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        @foreach($groupes as $groupe)
        <a href="@if(Auth::user()->role === 'professor') {{ route('professor.groupe.quizzes', $groupe->groupe) }} 
                  @elseif(Auth::user()->role === 'student') {{ route('student.groupe.quizzes', $groupe->groupe) }}
                  @else {{ route('admin.groupe.quizzes', $groupe->groupe) }} @endif" 
           style="text-decoration: none;">
            <div class="card" style="cursor: pointer; transition: all 0.3s; border-left: 4px solid #ef4444; height: 100%;">
                <h3 style="color: #ef4444; margin-bottom: 15px; font-size: 24px;">
                    👨‍👩‍👧‍👦 {{ $groupe->groupe }}
                </h3>
                <p style="color: #6b7280; margin-bottom: 8px; font-size: 16px;">
                    <strong>Quiz:</strong> {{ $groupe->quiz_count }}
                </p>
                <p style="color: #6b7280; font-size: 16px; margin-bottom: 15px;">
                    <strong>Modules:</strong> {{ count(explode(',', $groupe->modules)) }}
                </p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 15px;">
                    @foreach(explode(',', $groupe->modules) as $mod)
                    <span style="padding: 5px 12px; background: #667eea; color: white; border-radius: 15px; font-size: 12px; font-weight: 600;">
                        📚 {{ $mod }}
                    </span>
                    @endforeach
                </div>
                <p style="margin-top: 15px; color: #ef4444; font-size: 14px; font-weight: 600;">
                    Cliquer pour voir les quiz →
                </p>
            </div>
        </a>
        @endforeach
    </div>
</div>

<style>
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.15);
}
</style>
@endsection