<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }

    public function store()
    {
        $project = auth()->user()->projects()->create($this->validateRequest());
        return redirect($project->path());
    }

    public function show(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    // you can also use form objects
    // public function update(UpdateProjectRequest $request)
    // {

    //     return redirect($request->save()->path());
    // }

    public function update(Project $project)
    {
        $this->authorize('update', $project);
        $project->update($this->validateRequest());
        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    protected function validateRequest()
    {
        return $attr = request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
    }
}
