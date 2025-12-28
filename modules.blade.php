@extends('layouts.app')

@section('title', 'Tous les Modules')

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
    <h1>📚 Tous les Modules</h1>

    <div class="dashboard-stats" style="margin-top: 30px;">
        <div class="stat-card">
            <p>Total Modules</p>
            <h3>{{ $modules->count() }}</h3>
        </div>
    </div>

    <div style="margin-top: 30px; display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
        @foreach($modules as $module)
        <a href="@if(Auth::user()->role === 'professor') {{ route('professor.module.quizzes', $module->module) }} 
                  @elseif(Auth::user()->role === 'student') {{ route('student.module.quizzes', $module->module) }}
                  @else {{ route('admin.module.quizzes', $module->module) }} @endif" 
           style="text-decoration: none;">
            <div class="card" style="cursor: pointer; transition: all 0.3s; border-left: 4px solid #667eea; height: 100%;">
                <h3 style="color: #667eea; margin-bottom: 15px; font-size: 24px;">
                    📚 {{ $module->module }}
                </h3>
                <p style="color: #6b7280; margin-bottom: 8px; font-size: 16px;">
                    <strong>Quiz:</strong> {{ $module->quiz_count }}
                </p>
                <p style="color: #6b7280; font-size: 16px;">
                    <strong>Groupes:</strong> {{ $module->groupe_count }}
                </p>
                <p style="margin-top: 15px; color: #667eea; font-size: 14px; font-weight: 600;">
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