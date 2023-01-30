<?php

namespace App\Http\Controllers\Api;

use App\Events\NotificationEventLike;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Like;
use App\Models\Song;
use App\Models\User;
use App\Notifications\LikeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SongController extends Controller
{
    public function create(Request $request)
    {
        $user = Auth::user();
        if ($user->can('create', Song::class)) {
            try {
                $image = $request->file('image');
                $image_name = date('YmdHi') . '-' . $image->getClientOriginalName();
                $image->storeAs('images', $image_name);

                $audio = $request->file(('audio'));
                $audio_name = date('YmdHi') . '-' . $audio->getClientOriginalName();
                $audio->storeAs('audios', $audio_name);

                Song::create([
                    'name' => $request->name,
                    'artist' => $request->artist,
                    'image' => $image_name,
                    'audio' => $audio_name,
                ]);

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
        $song = DB::table('songs')->where('id', $id)->select('songs.audio')->first();

        if ($song) {
            return response()->json([
                'status' => 200,
                'message' => 'Succes',
                'items' => $song,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Song Not Found'
            ], 404);
        }
    }
    public function like(Request $request, $id)
    {
        Like::create([
            'song_id' => $id,
            'user_id' => Auth::id()
        ]);

        $user = User::find(Auth::id());

        $like = ['content' => 'Added to favorites'];

        $user->notify(new LikeNotification($like));

        event(new NotificationEventLike($user->unreadNotifications->first()));

        return response()->json([
            'status' => 200,
            'message' => 'Succes'
        ], 200);
    }
}
