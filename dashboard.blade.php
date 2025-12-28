@extends('layouts.app')

@section('title', 'Dashboard Étudiant')

@section('content')
<div class="navbar">
    <div class="navbar-brand">Quiz App - Étudiant</div>
    <div class="navbar-menu">
        <a href="{{ route('student.dashboard') }}" class="navbar-link">📊 Dashboard</a>
        <span style="color: #6b7280;">👤 {{ Auth::user()->name }}</span>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-secondary">🚪 Déconnexion</button>
        </form>
    </div>
</div>

<div class="container">
    <h1 style="margin-bottom: 30px;">📊 Tableau de bord</h1>

    <div class="dashboard-stats">
        <a href="{{ route('student.users') }}" style="text-decoration: none;">
            <div class="stat-card" style="border-top: 4px solid #667eea;">
                <div style="font-size: 40px; margin-bottom: 10px;">👥</div>
                <p>Total Utilisateurs</p>
                <h3 style="color: #667eea;">{{ $statistics['total_users'] }}</h3>
                <p style="font-size: 12px; color: #6b7280; margin-top: 10px;">Cliquer pour voir détails →</p>
            </div>
        </a>

        <a href="{{ route('student.quizzes') }}" style="text-decoration: none;">
            <div class="stat-card" style="border-top: 4px solid #10b981;">
                <div style="font-size: 40px; margin-bottom: 10px;">📝</div>
                <p>Total Quiz</p>
                <h3 style="color: #10b981;">{{ $statistics['total_quizzes'] }}</h3>
                <p style="font-size: 12px; color: #6b7280; margin-top: 10px;">Cliquer pour voir détails →</p>
            </div>
        </a>

        <a href="{{ route('student.modules') }}" style="text-decoration: none;">
            <div class="stat-card" style="border-top: 4px solid #f59e0b;">
                <div style="font-size: 40px; margin-bottom: 10px;">📚</div>
                <p>Total Modules</p>
                <h3 style="color: #f59e0b;">{{ $statistics['total_modules'] }}</h3>
                <p style="font-size: 12px; color: #6b7280; margin-top: 10px;">Cliquer pour voir détails →</p>
            </div>
        </a>

        <a href="{{ route('student.groupes') }}" style="text-decoration: none;">
            <div class="stat-card" style="border-top: 4px solid #ef4444;">
                <div style="font-size: 40px; margin-bottom: 10px;">👨‍👩‍👧‍👦</div>
                <p>Total Groupes</p>
                <h3 style="color: #ef4444;">{{ $statistics['total_groupes'] }}</h3>
                <p style="font-size: 12px; color: #6b7280; margin-top: 10px;">Cliquer pour voir détails →</p>
            </div>
        </a>
    </div>
</div>
@endsection