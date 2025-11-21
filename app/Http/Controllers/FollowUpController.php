<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use App\Models\Project;
use Illuminate\Http\Request;

class FollowUpController extends Controller
{
    /**
     * Show Follow-Up Form
     */
    public function add($id)
    {
        $project = Project::findOrFail($id);
        return view('projects.followup', compact('project'));
    }

    /**
     * Store Follow-Up
     */
    public function store(Request $request, $id)
    {
        // Validate user input
        $request->validate([
            'heading' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Get the project
        $project = Project::findOrFail($id);


        if ($project->status === 'not_started') {
            $project->status = 'in_progress';
            $project->save();
        }


        // Create follow-up
        FollowUp::create([
            'project_id' => $project->id,
            'user_id' => auth()->id(),
            'heading' => $request->heading,
            'description' => $request->description,
        ]);

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Follow-up added successfully.');
    }
}
