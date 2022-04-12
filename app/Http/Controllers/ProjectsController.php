<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        dd('balegde');
        // validate
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required'
        ]);

        $attributes['owner_id'] = auth()->id();

        // persist
        Project::create($attributes);

        // redirect
        return redirect('/projects');
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }
}
