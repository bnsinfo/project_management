<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Client;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index()
    {
        $user = auth()->user();

        // Admin → ALL Projects
        if ($user->hasRole('admin')) {
            $projects = Project::with(['assignedUser', 'client'])
                ->latest()
                ->paginate(10);

            return view('projects.index', compact('projects'));
        }

        // Users with permission → ALL
        if ($user->can('project.view')) {
            $projects = Project::with(['assignedUser', 'client'])
                ->latest()
                ->paginate(10);

            return view('projects.index', compact('projects'));
        }

        // Normal Users → Own Projects Only
        $projects = Project::with(['assignedUser', 'client'])
            ->where('assigned_to', $user->id)
            ->latest()
            ->paginate(10);

        return view('projects.index', compact('projects'));
    }


    /**
     * Show Create Project Form
     */
    public function create()
    {
        $users = User::role('user')->get();
        $clients = Client::all();

        return view('projects.create', compact('users', 'clients'));
    }


    /**
     * Store New Project
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id'   => 'nullable|exists:clients,id',
            'title'       => 'required',
            'description' => 'nullable',
            'assigned_to' => 'nullable|exists:users,id',
            'boudget'     => 'nullable|numeric',
            'deadline'    => 'nullable|date',
        ]);

        Project::create($request->all());

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }


    /**
     * Show Single Project
     */
    public function show(Project $project)
    {
        $user = auth()->user();

        // Access Validation
        if (
            !$user->hasRole('admin') &&
            !$user->can('project.view') &&
            $project->assigned_to != $user->id
        ) {
            abort(403, 'Unauthorized access.');
        }

        $users = User::role('user')->get();
        $clients = Client::all();

        $followUps = $project->followUps()
            ->with('user')
            ->latest()
            ->get();

        $payments = $project->payments()
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPaid = $payments->sum('amount');

        return view('projects.show', compact(
            'project',
            'users',
            'clients',
            'followUps',
            'payments',
            'totalPaid'
        ));
    }


    /**
     * Edit Project Form
     */
    public function edit(Project $project)
    {
        $users = User::role('user')->get();
        $clients = Client::all();

        return view('projects.edit', compact('project', 'users', 'clients'));
    }


    /**
     * Update Project
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'client_id'   => 'nullable|exists:clients,id',
            'title'       => 'required',
            'description' => 'nullable',
            'assigned_to' => 'nullable|exists:users,id',
            'deadline'    => 'nullable|date',
            'status'      => 'required',
            'boudget'     => 'nullable|numeric',
        ]);

        $project->update($request->all());

        return redirect()->route('projects.show', $project)
            ->with('success', 'Project updated successfully.');
    }


    /**
     * Delete Project
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }


    /**
     * Update Status (dropdown)
     */
    public function updateStatus(Request $request, Project $project)
    {
        $request->validate([
            'status' => 'required|in:not_started,in_progress,stuck,completed'
        ]);

        $project->status = $request->status;
        $project->save();

        return back()->with('success', 'Status updated successfully.');
    }
}
