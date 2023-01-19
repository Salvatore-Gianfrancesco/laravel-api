<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.create', compact('types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreProjectRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $validated = $request->validated();
        // dd($validated);

        if ($request->hasFile('cover_img')) {
            $cover_img = Storage::put('uploads', $validated['cover_img']);
            $validated['cover_img'] = $cover_img;
        }

        $project = Project::create($validated);

        if ($request->has('technologies')) {
            $project->technologies()->attach($validated['technologies']);
        }

        return to_route('admin.projects.index')->with('message', 'Project ' . $project->id . ' stored successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        $technologies = Technology::all();

        return view('admin.projects.edit', compact('project', 'types', 'technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProjectRequest  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $validated = $request->validated();
        // dd($validated);

        if ($request->hasFile('cover_img')) {
            if ($project->cover_img) {
                Storage::delete($project->cover_img);
            }
            $cover_img = Storage::put('uploads', $validated['cover_img']);
            $validated['cover_img'] = $cover_img;
        }

        $project->update($validated);

        if ($request->has('technologies')) {
            $project->technologies()->sync($validated['technologies']);
        } else {
            $project->technologies()->sync([]);
        }

        return to_route('admin.projects.index')->with('message', 'Project ' . $project->id . ' edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        if ($project->cover_img) {
            Storage::delete($project->cover_img);
        }

        $project->delete();

        return to_route('admin.projects.index')->with('message', 'Project ' . $project->id . ' deleted successfully!');
    }
}
