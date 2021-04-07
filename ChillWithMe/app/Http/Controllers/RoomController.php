<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Models\User;
use App\Models\Song;
use App\Models\Room;

class RoomController extends Controller
{
    public function index(Request $req)
    {
        $idRoom = $req->idRoom;
        $room = Room::find($idRoom);
        $roomMaster = User::find($idRoom);

        if (Auth::user()->id == $roomMaster->id) {
            if (!isset($room)) {
                $newRoom = new Room;
                $newRoom->idRoom = $idRoom;
                $newRoom->playing = false;
                $newRoom->save();
            }
        } else {
            if (!isset($room)) {
                return redirect('404');
            } else {
                if ($roomMaster->idRoom != $idRoom) {
                    return redirect('404');
                }
            }
        }

        $user = User::find(Auth::user()->id);
        $user->idRoom = $req->idRoom;
        $user->save();
        $songs = Song::where('idRoom', $idRoom)->get();
        return view('room', [
            'idRoom' => $roomMaster->id,
            'masterRoom' => $roomMaster->name,
            'songs' => $songs
        ]);
    }

    public function addQueue()
    {
    }
}
