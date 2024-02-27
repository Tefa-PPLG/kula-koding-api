<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Komentar;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    function Index() {
        $komentar = Komentar::all()->last();

        return response()->json([
            "data" => $komentar
        ], 200);
    }
}
