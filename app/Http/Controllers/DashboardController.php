<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\DashboardRequest;
use App\Models\Config;
use App\Models\Image;

class DashboardController extends Controller
{
    function Index() {
        $config = Config::with("Image")->get();

        return response()->json([
            "config" => $config
        ], 200);
    }

    function Store(DashboardRequest $request) {
        $payload = $request->validated();        

        // return $payload;

        $config = Config::create($payload);

        foreach ($request->file('image') as $image) {
            $extension = $image->extension();
            $dir = "storage/config/";
            $name = Str::random(32) . '.' . $extension;
            $foto = $dir . $name;
            $image->move($dir, $name);

            Image::create([
                "config_id" => $config->id,
                "image" => $foto
            ]);
        }

        return response()->json([
            "message" => "Data berhasil ditambahkan!"
        ], 201);
    }

    function Update($id, DashboardRequest $request) {
        $config = Config::firstWhere("id", $id);
        $payload = $request->validated();

        $config->update($payload);

        return response()->json([
            "message" => "Data berhasil diupdate!"
        ], 200);
    }

    function Show($id) {
        $config = Config::firstWhere("id", $id);

        return $config;
    }
}
