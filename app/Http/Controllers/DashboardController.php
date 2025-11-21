<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // ================================
        // ADMIN DASHBOARD DATA
        // ================================
        if ($user->hasRole('admin')) {

            $totalBudget = Project::sum('boudget'); // your field name is "boudget"

            $stats = [
                'total_projects'     => Project::count(),
                'completed_projects' => Project::where('status', 'completed')->count(),
                'in_progress'        => Project::where('status', 'in_progress')->count(),
                'stuck'              => Project::where('status', 'stuck')->count(),
                'not_started'        => Project::where('status', 'not_started')->count(),

                'total_budget'       => $totalBudget,

                'total_received'     => Payment::where('payment_type', 'received')->sum('amount'),
                'total_paid'         => Payment::where('payment_type', 'paid')->sum('amount'),
            ];

            return view('dashboard', compact('stats'));
        }

        // ================================
        // USER DASHBOARD DATA
        // ================================
        if ($user->hasRole('user')) {

            $myProjects = Project::where('assigned_to', $user->id);

            $totalUserBudget = $myProjects->sum('boudget');

            $stats = [
                'total_my_projects'  => $myProjects->count(),
                'my_completed'       => $myProjects->clone()->where('status', 'completed')->count(),
                'my_in_progress'     => $myProjects->clone()->where('status', 'in_progress')->count(),
                'my_stuck'           => $myProjects->clone()->where('status', 'stuck')->count(),
                'my_not_started'     => $myProjects->clone()->where('status', 'not_started')->count(),

                'total_user_budget'  => $totalUserBudget,
            ];

            return view('dashboard', compact('stats'));
        }

        return view('dashboard');
    }
}
