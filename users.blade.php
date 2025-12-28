@extends('layouts.app')

@section('title', 'Tous les Utilisateurs')

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
    <h1>👥 Tous les Utilisateurs</h1>

    <div class="dashboard-stats" style="margin-top: 30px;">
        <div class="stat-card">
            <p>Total Utilisateurs</p>
            <h3>{{ $users->count() }}</h3>
        </div>
        <div class="stat-card">
            <p>Étudiants</p>
            <h3>{{ $breakdown['students'] }}</h3>
        </div>
        <div class="stat-card">
            <p>Professeurs</p>
            <h3>{{ $breakdown['professors'] }}</h3>
        </div>
        <div class="stat-card">
            <p>Administrateurs</p>
            <h3>{{ $breakdown['admins'] }}</h3>
        </div>
    </div>

    <div class="card" style="margin-top: 30px;">
        <h3 style="margin-bottom: 20px; color: #667eea;">Liste des utilisateurs</h3>
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Module</th>
                    <th>Groupe</th>
                    <th>Date d'inscription</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span style="padding: 5px 10px; border-radius: 5px; font-size: 12px; font-weight: 600;
                            @if($user->role === 'admin') background: #fee2e2; color: #991b1b;
                            @elseif($user->role === 'professor') background: #dbeafe; color: #1e40af;
                            @else background: #d1fae5; color: #065f46; @endif">
                            @if($user->role === 'student') 👨‍🎓 Étudiant
                            @elseif($user->role === 'professor') 👨‍🏫 Professeur
                            @else 👨‍💼 Admin @endif
                        </span>
                    </td>
                    <td>{{ $user->module ?? '-' }}</td>
                    <td>{{ $user->groupe ?? '-' }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection