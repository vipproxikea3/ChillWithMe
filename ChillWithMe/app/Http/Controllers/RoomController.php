<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use app\Models\User;
use App\Models\Song;

class RoomController extends Controller
{
    public function index(Request $req)
    {
        $idRoom = $req->idRoom;
        $room = User::find($idRoom);
        if (!isset($room))
            return redirect('404');
        $user = User::find(Auth::user()->id);
        $user->idRoom = $req->idRoom;
        $user->save();
        $songs = Song::where('idRoom', $idRoom)->get();
        return view('room', [
            'idRoom' => $room->id,
            'masterRoom' => $room->name,
            'songs' => $songs
        ]);
    }
}
