<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Section;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    //

    public function create(Request $request)
    {
        $thumbnail = $request->file('thumbnail');
        $thumbnail_name = date('YmdHi') . '-' . $thumbnail->getClientOriginalName();
        $thumbnail->storeAs('images', $thumbnail_name);

        $slider = Slider::create([
            'thumbnail' => $thumbnail_name,
        ]);

        $section = Section::find(1);

        $slider->sections()->attach($section);
    }
}
