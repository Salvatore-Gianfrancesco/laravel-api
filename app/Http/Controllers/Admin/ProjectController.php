<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // select all projects stored in the database
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
        // select all types and technologies stored in the database
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
        // validate the request
        $validated = $request->validated();
        // dd($validated);

        // create the slug of the project
        $slug = Str::slug($validated['name']);
        $validated['slug'] = $slug;

        // if the request has an image store it in the storage linked folder
        if ($request->hasFile('cover_img')) {
            $cover_img = Storage::put('uploads', $validated['cover_img']);
            $validated['cover_img'] = $cover_img;
        }

        // create the new project with validated data
        $project = Project::create($validated);

        // if the project has technologies store them in the pivot table
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
        // select all types and technologies stored in the database
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
        // validate the request
        $validated = $request->validated();
        // dd($validated);

        // update the slug
        $slug = Str::slug($validated['name']);
        $validated['slug'] = $slug;

        // if there is an image in the request
        if ($request->hasFile('cover_img')) {
            // if the project has already an image, delete it
            if ($project->cover_img) {
                Storage::delete($project->cover_img);
            }
            // store the new image in the storage linked folder
            $cover_img = Storage::put('uploads', $validated['cover_img']);
            $validated['cover_img'] = $cover_img;
        }

        // update the project
        $project->update($validated);

        // if the request has technologies sync them in the pivot table 
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
        // if the project has an image delete it from the storage linked folder
        if ($project->cover_img) {
            Storage::delete($project->cover_img);
        }

        // delete the project
        $project->delete();

        return to_route('admin.projects.index')->with('message', 'Project ' . $project->id . ' deleted successfully!');
    }

    public function delete_image(Project $project)
    {
        dd('deleting image');
    }
}
