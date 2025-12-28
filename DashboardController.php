<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'student') {
            $quizzes = Quiz::all();
            return view('dashboard.student', compact('quizzes'));
        } else {
            // Admin/Professor Dashboard
            $totalUsers = User::count();
            $totalQuizzes = Quiz::count();
            $totalModules = Quiz::distinct('module')->count('module');
            $totalGroupes = Quiz::distinct('groupe')->count('groupe');
            $recentQuizzes = Quiz::orderBy('created_at', 'desc')->take(5)->get();
            
            return view('dashboard.admin', compact(
                'totalUsers',
                'totalQuizzes',
                'totalModules',
                'totalGroupes',
                'recentQuizzes'
            ));
        }
    }
}
