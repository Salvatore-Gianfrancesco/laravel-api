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
        // return all projects stored in the database as json file
        return response()->json([
            'success' => true,
            'results' => Project::with('type', 'technologies')->paginate(6)
        ]);
    }

    public function show($slug)
    {
        // saves the project of given slug
        $project = Project::with('type', 'technologies')->where('slug', $slug)->first();

        if ($project) {
            // if the project with the given slug exist
            return response()->json([
                'success' => true,
                'results' => $project
            ]);
        } else {
            // if the project with the given slug NOT exist
            return response()->json([
                'success' => false,
                'results' => 'Project not found...'
            ]);
        }
    }
}
