<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Song;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $section = Section::with('sliders')->where('id', 1)->first();
        $section1 = Section::with('albums')->where('id', 2)->first();
        $section2 = Section::with('albums')->where('id', 3)->first();

        return response()->json([
            'items' => [$section, $section1, $section2]
        ], 200);
    }
    public function search(Request $request)
    {
        $search = Song::where('name','LIKE','%'.$request->keywork.'%')->get();
        return response()->json([
            'items' => $search
        ], 200);
    }
}
