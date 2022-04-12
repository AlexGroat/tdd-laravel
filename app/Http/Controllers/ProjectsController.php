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
        // validate

        // persist
        Project::create(request(['title', 'body']));
        
        // redirect
        return redirect('/projects');
    }
}
