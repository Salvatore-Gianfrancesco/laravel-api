<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Integer;

class ProjectController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'results' => Project::with('type', 'technologies')->paginate(6)
        ]);
    }

    public function show($slug)
    {
        return response()->json([
            'success' => true,
            'results' => Project::with('type', 'technologies')->where('slug', $slug)->get()
        ]);
    }
}
