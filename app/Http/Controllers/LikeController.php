<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    function store(Request $request) {
        $user = Auth::user();
        $payload = [
            "user_id" => $user->id,
            "project_id" => $request->project_id,
            "komentar_id" => $request->komentar_id
        ];

        Like::create($payload);
    }

    function show($id) {
        $project = Project::firstWhere("id", $id);

        $like = Like::where("project_id", $project->id)->get();

        return response()->json([
            "data" => $like,
            "total" => $like->count()
        ], 200);
    }
}
