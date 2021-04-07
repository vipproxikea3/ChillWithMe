<?php

namespace App\Http\Controllers;

use App\Models\Song;

use Illuminate\Http\Request;
use Pusher\Pusher;

class SongController extends Controller
{
    public function addQueue(Request $req)
    {
        $idVideo = $req->idVideo;
        $thumbnail = $req->thumbnail;
        $title = $req->title;
        $channeltitle = $req->channeltitle;
        $idRoom = $req->idRoom;
        $idUser = $req->idUser;

        $song = new Song;
        $song->idVideo = $idVideo;
        $song->thumbnail = $thumbnail;
        $song->title = $title;
        $song->channelTitle = $channeltitle;
        $song->idRoom = $idRoom;
        $song->idUser = $idUser;

        $song->save();

        $songs = Song::where('idRoom', $idRoom)->get();

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => 'ap1',
                'encrypted' => true
            ]
        );
        //channel is auth role and id, ex: user_id_1 or influencer_id1
        $pusher->trigger('test-channel', 'test-event', $songs);
    }
}
