<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function store()
    {
        $attr = request()->validate(['title' => 'required', 'description' => 'required']);
        Project::create($attr);
        return redirect('/projects');
    }
}