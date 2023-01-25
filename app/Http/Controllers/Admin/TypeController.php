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
        // validate the request and store the new type instance in the database
        $val_data = $request->validated();
        $type = new Type();
        $type->name = $val_data['name'];
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
        // validate the request and update the type instance in the database
        $val_data = $request->validated();
        $type->name = $val_data['name-' . $type->id];
        $type->update();

        return to_route('admin.types.index')->with('message', 'Type ' . $type->id . ' stored successfully!');
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
