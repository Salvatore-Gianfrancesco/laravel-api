<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technology;
use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // select all technologies stored in the database
        $technologies = Technology::all();

        return view('admin.technologies.index', compact('technologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTechnologyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTechnologyRequest $request)
    {
        // validate the request and store the new technology instance in the database
        $val_data = $request->validated();
        $technology = new Technology();
        $technology->name = $val_data['name'];

        // if the request has an image store it in the storage linked folder
        if ($request->hasFile('icon')) {
            $icon = Storage::put('uploads', $val_data['icon']);
            $technology['icon'] = $icon;
        }

        $technology->save();

        return to_route('admin.technologies.index')->with('message', 'Technology ' . $technology->id . ' stored successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function show(Technology $technology)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function edit(Technology $technology)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTechnologyRequest  $request
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTechnologyRequest $request, Technology $technology)
    {
        // validate the request and edit the technology instance in the database
        $val_data = $request->validated();
        $technology->name = $val_data['name-' . $technology->id];

        // if the request has an icon
        if ($request->hasFile('icon-' . $technology->id)) {
            // if the technology has already an icon, delete it
            if ($technology->icon) {
                Storage::delete($technology->icon);
            }
            // store the new icon in the storage linked folder
            $icon = Storage::put('uploads', $val_data['icon-' . $technology->id]);
            $technology['icon'] = $icon;
        }

        $technology->update();

        return to_route('admin.technologies.index')->with('message', 'Technology ' . $technology->id . ' edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        // if the technology has an icon, delete it
        if ($technology->icon) {
            Storage::delete($technology->icon);
        }

        // delete the technology
        $technology->delete();

        return to_route('admin.technologies.index')->with('message', 'Technology ' . $technology->id . ' deleted successfully!');
    }
}
