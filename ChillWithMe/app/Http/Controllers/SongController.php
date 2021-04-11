<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Room;

use Illuminate\Http\Request;
use Pusher\Pusher;

class SongController extends Controller
{
    public function addQueue(Request $req)
    {
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => 'ap1',
                'encrypted' => true
            ]
        );

        // setup variable
        $idVideo = $req->idVideo;
        $thumbnail = $req->thumbnail;
        $title = $req->title;
        $channeltitle = $req->channeltitle;
        $idRoom = $req->idRoom;
        $idUser = $req->idUser;

        //check room
        $room = Room::where('idRoom', $idRoom)->first();
        if (isset($room) && $room->playing == 0) {
            $song = (object) [
                'idVideo' => $idVideo,
                'thumbnail' => $thumbnail,
                'title' => $title,
                'channeltitle' => $channeltitle,
                'idRoom' => $idRoom,
                'idUser' => $idUser,
            ];

            $pusher->trigger('room', 'play', $song);
            $room->playing = 1;
            $room->save();
        } else {
            $song = new Song;
            $song->idVideo = $idVideo;
            $song->thumbnail = $thumbnail;
            $song->title = $title;
            $song->channelTitle = $channeltitle;
            $song->idRoom = $idRoom;
            $song->idUser = $idUser;

            $song->save();
        }

        $songs = Song::where('idRoom', $idRoom)->get();

        //channel is auth role and id, ex: user_id_1 or influencer_id1
        $pusher->trigger('room', 'queue', $songs);
    }

    public function playSong(Request $req)
    {
        $id = $req->idSong;

        $song = Song::find($id);
        $idRoom = $song->idRoom;

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
        $pusher->trigger('room', 'play', $song);
        $song->delete();

        $songs = Song::where('idRoom', $idRoom)->get();
        $pusher->trigger('room', 'queue', $songs);
    }

    public function nextSong(Request $req)
    {
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            [
                'cluster' => 'ap1',
                'encrypted' => true
            ]
        );

        $idRoom = $req->idRoom;

        $song = Song::where('idRoom', $idRoom)->first();
        if (isset($song)) {
            $pusher->trigger('room', 'play', $song);
            $song->delete();
        } else {
            $room = Room::where('idRoom', $idRoom)->first();
            if (isset($room)) {
                $room->playing = 0;
                $room->save();
            }
        }

        $songs = Song::where('idRoom', $idRoom)->get();
        $pusher->trigger('room', 'queue', $songs);
    }
}
