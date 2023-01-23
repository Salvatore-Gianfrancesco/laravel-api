<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Http\Requests\StoreTypesRequest;
use App\Http\Requests\UpdateTypesRequest;
use Illuminate\Support\Str;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // select all types stored in the database
        $types = Type::all();

        return view('admin.types.index', compact('types'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTypesRequest $request)
    {
        // create a new instance of Type and store it in the database
        $type = new Type();
        $type->name = $request['name'];
        $type->slug = Str::slug($type->name);
        $type->save();

        return to_route('admin.types.index')->with('message', 'Type ' . $type->id . ' stored successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTypesRequest $request, Type $type)
    {
        // update the type and save changes in the database
        $type->name = $request['name'];
        $type->slug = Str::slug($type->name);
        $type->save();

        return to_route('admin.types.index')->with('message', 'Type ' . $type->id . ' edited successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        // delete the type
        $type->delete();

        return to_route('admin.types.index')->with('message', 'Type ' . $type->id . ' deleted successfully!');
    }
}
