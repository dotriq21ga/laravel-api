<?php

namespace App\Http\Controllers\Api;

use App\Events\NotificationEventLike;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Like;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AlbumController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();
        if ($user->can('create', Album::class)) {
            try {
                $banner = $request->file('banner');
                $banner_name = date('YmdHi') . '-' . $banner->getClientOriginalName();
                $banner->storeAs('images', $banner_name);

                $album = Album::create([
                    'title' => $request->title,
                    'artists' => $request->artists,
                    'banner' => $banner_name,
                    'sort_description' =>  $request->sort_description,
                ]);

                $section = Section::find($request->option);

                $album->sections()->attach($section);

                return response()->json([
                    'status' => 200,
                    'message' => "Succes",
                ], 200);
            } catch (\Throwable $th) {
                return response()->json([
                    'status' => 404,
                    'message' => $th,
                ], 404);
            }
        } else {
            return response()->json([
                'status' => 403,
                'message' => 'Forbidden Error'
            ], 403);
        }
    }

    public function show($id)
    {
        $album = Album::with('songs')->where('id', $id)->first();
        if ($album) {
            if (Auth::user()) {
                foreach ($album->songs as $key) {
                    $key['has_like'] = boolval(Like::where('song_id', $key->id)->where('user_id', Auth::id())->first());
                }
            } else {
                foreach ($album->songs as $key) {
                    $key['has_like'] = false;
                }
            }
            return response()->json([
                'status' => 200,
                'message' => 'Succes',
                'items' => $album
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Page Not Found'
            ], 404);
        }
    }
}
