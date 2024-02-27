<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blog = Blog::with("user")->get();

        return response()->json($blog, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogRequest $request)
    {
        $payload = $request->validated();
        $user = Auth::user();

        $payload["user_id"] = $user->id;

        $image = $request->file("thumbnail");

        $extension = $image->extension();
        $dir = "storage/blog/";
        $name = Str::random(32) . '.' . $extension;
        $foto = $dir . $name;
        $payload["thumbnail"] = $foto;
        $image->move($dir, $name);

        $blog = Blog::create($payload);

        return response()->json([
            "message" => "Blog added successful"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $blog = Blog::with("user")->where("slug", $slug)->get();

        return response()->json($blog, 200);
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogRequest $request, Blog $blog)
    {
        $payload = $request->validated();
        
        return $payload;

        $image = $request->file("thumbnail");

        $extension = $image->extension();
        $dir = "storage/blog/";
        $name = Str::random(32) . '.' . $extension;
        $foto = $dir . $name;
        $payload["thumbnail"] = $foto;
        $image->move($dir, $name);

        // $blog = Blog::update($payload);

        return response()->json([
            "message" => "Blog edited successful"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
