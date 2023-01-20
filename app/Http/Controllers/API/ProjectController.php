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
        // se lo slug è nel database restituisce l'oggetto corrispondente, altrimenti un array vuoto
        return response()->json([
            'success' => true,
            'results' => Project::where('slug', $slug)->get()
        ]);
    }
}
